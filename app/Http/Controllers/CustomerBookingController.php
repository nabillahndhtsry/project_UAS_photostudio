<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CustomerBookingController extends Controller
{
    // Halaman welcome dengan data studios dari database
    public function indexWelcome()
    {
        $studios = DB::table('studio')
            ->where('status', 'tersedia')
            ->orderBy('id')
            ->get();

        return view('welcome', compact('studios'));
    }

    // List studio untuk customer
    public function listStudio()
    {
        $studios = DB::table('studio')
            ->where('status', 'tersedia')
            ->orderBy('nama')
            ->get();

        return view('customer.studio_list', compact('studios'));
    }

    // Detail studio
    public function showStudio($id)
    {
        $studio = DB::table('studio')->where('id', $id)->first();
        
        if (!$studio) {
            return redirect('/customer/studio')->with('error', 'Studio tidak ditemukan.');
        }

        // Cek jadwal yang sudah dibooking pada hari tertentu
        $booked_slots = DB::table('booking_studio')
            ->where('studio_id', $id)
            ->where('status_booking', '!=', 'dibatalkan')
            ->select('tanggal_booking', 'jam_mulai', 'jam_selesai')
            ->get();

        // Cek apakah datang dari welcome (referrer)
        $referrer = request()->headers->get('referer');
        $isFromWelcome = $referrer && preg_match('#/$#', $referrer);
        session(['from_welcome' => $isFromWelcome]);

        return view('customer.studio_detail', compact('studio', 'booked_slots'));
    }

    // Form booking
    public function createBooking($studio_id)
    {
        if (!Session::get('login')) {
            // Simpan intended URL untuk redirect setelah login
            session(['intended_url' => route('customer.booking.create', $studio_id)]);
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $studio = DB::table('studio')->where('id', $studio_id)->first();
        
        if (!$studio) {
            return redirect('/customer/studio')->with('error', 'Studio tidak ditemukan.');
        }

        return view('customer.booking_create', compact('studio'));
    }

    // Proses booking
    public function storeBooking(Request $request)
{
    if (!Session::get('login')) {
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
    }

    $request->validate([
        'studio_id' => 'required|exists:studio,id',
        'tanggal_booking' => 'required|date|after_or_equal:today',
        'jam_mulai' => 'required',
        'jam_selesai' => 'required|after:jam_mulai'
    ]);

    // Cek konflik jadwal
    $conflict = DB::table('booking_studio')
        ->where('studio_id', $request->studio_id)
        ->where('tanggal_booking', $request->tanggal_booking)
        ->where('status_booking', '!=', 'dibatalkan')
        ->where(function($query) use ($request) {
            $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhere(function($q) use ($request) {
                      $q->where('jam_mulai', '<=', $request->jam_mulai)
                        ->where('jam_selesai', '>=', $request->jam_selesai);
                  });
        })
        ->exists();

    if ($conflict) {
        return back()->with('error', 'Studio sudah dibooking pada jam tersebut. Silakan pilih jam lain.');
    }

    // Hitung durasi dan total harga
    $studio = DB::table('studio')->where('id', $request->studio_id)->first();
    $durasi_jam = (strtotime($request->jam_selesai) - strtotime($request->jam_mulai)) / 3600;
    $total_harga = $durasi_jam * $studio->harga_per_jam;

    // Simpan booking
    $booking_id = DB::table('booking_studio')->insertGetId([
        'user_id' => Session::get('user_id'),
        'studio_id' => $request->studio_id,
        'tanggal_booking' => $request->tanggal_booking,
        'jam_mulai' => $request->jam_mulai,
        'jam_selesai' => $request->jam_selesai,
        'status_booking' => 'pending', // SELALU PENDING SAAT DIBUAT
        'created_at' => now(),
        'updated_at' => now()
    ]);

    // Otomatis buat data pembayaran dengan status BELUM LUNAS
    DB::table('pembayaran')->insert([
        'booking_id' => $booking_id,
        'total_bayar' => $total_harga,
        'metode_bayar' => 'transfer', // default
        'status_bayar' => 'belum_lunas', // AWALNYA BELUM LUNAS
        'tanggal_bayar' => null, // BELUM BAYAR
        'created_at' => now(),
        'updated_at' => now()
    ]);

    return redirect()->route('customer.pembayaran')->with('success', 'Booking berhasil dibuat! Status: Pending. Silakan lakukan pembayaran.');
}

// Riwayat booking customer
public function bookingHistory()
{
    if (!Session::get('login')) {
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
    }

    $bookings = DB::table('booking_studio as b')
        ->join('studio as s', 'b.studio_id', '=', 's.id')
        ->leftJoin('pembayaran as p', 'b.id', '=', 'p.booking_id')
        ->where('b.user_id', Session::get('user_id'))
        ->select('b.*', 's.nama as studio_name', 's.gambar', 's.harga_per_jam', 'p.status_bayar', 'p.total_bayar')
        ->orderBy('b.created_at', 'desc')
        ->paginate(10);

    return view('customer.booking_history', compact('bookings'));
}

    // Detail booking customer
    public function bookingDetail($id)
    {
        if (!Session::get('login')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $booking = DB::table('booking_studio as b')
            ->join('studio as s', 'b.studio_id', '=', 's.id')
            ->leftJoin('pembayaran as p', 'b.id', '=', 'p.booking_id')
            ->where('b.id', $id)
            ->where('b.user_id', Session::get('user_id'))
            ->select('b.*', 's.nama as studio_name', 's.gambar', 's.harga_per_jam', 's.deskripsi', 
                     'p.status_bayar', 'p.total_bayar', 'p.metode_bayar', 'p.tanggal_bayar', 'p.bukti_pembayaran')
            ->first();

        if (!$booking) {
            return redirect('/customer/booking')->with('error', 'Booking tidak ditemukan.');
        }

        // Hitung durasi
        $durasi_jam = (strtotime($booking->jam_selesai) - strtotime($booking->jam_mulai)) / 3600;

        return view('customer.booking_detail', compact('booking', 'durasi_jam'));
    }

    // Batalkan booking (hanya jika status pending)
    public function cancelBooking($id)
    {
        if (!Session::get('login')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $booking = DB::table('booking_studio')
            ->where('id', $id)
            ->where('user_id', Session::get('user_id'))
            ->first();

        if (!$booking) {
            return redirect('/customer/booking')->with('error', 'Booking tidak ditemukan.');
        }

        if ($booking->status_booking != 'pending') {
            return redirect('/customer/booking/' . $id)->with('error', 'Hanya booking dengan status pending yang bisa dibatalkan.');
        }

        DB::table('booking_studio')->where('id', $id)->update([
            'status_booking' => 'dibatalkan',
            'updated_at' => now()
        ]);

        return redirect()->route('customer.booking.history')->with('success', 'Booking berhasil dibatalkan.');
    }
}