<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BookingController extends Controller
{
    // LIST BOOKING (Admin)
    public function index()
    {
        if (!Session::get('login') || Session::get('role') != 'admin') {
            Session::flash('error', 'Silakan login sebagai admin terlebih dahulu.');
            return redirect('/login');
        }

        // Ambil semua booking dengan join user, studio, dan status pembayaran
        $bookings = DB::table('booking_studio as b')
            ->join('users as u', 'b.user_id', '=', 'u.id')
            ->join('studio as s', 'b.studio_id', '=', 's.id')
            ->leftJoin('pembayaran as p', 'b.id', '=', 'p.booking_id')
            ->select(
                'b.*', 
                'u.name as customer_name', 
                'u.email', 
                'u.phone', 
                's.nama as studio_name', 
                's.harga_per_jam',
                'p.status_bayar',
                'p.total_bayar as total_pembayaran'
            )
            ->orderBy('b.created_at', 'desc')
            ->paginate(10);

        return view('admin.booking_index', compact('bookings'));
    }

    // DETAIL BOOKING
    public function show($id)
    {
        if (!Session::get('login') || Session::get('role') != 'admin') {
            Session::flash('error', 'Silakan login sebagai admin terlebih dahulu.');
            return redirect('/login');
        }

        $booking = DB::table('booking_studio as b')
            ->join('users as u', 'b.user_id', '=', 'u.id')
            ->join('studio as s', 'b.studio_id', '=', 's.id')
            ->where('b.id', $id)
            ->select('b.*', 'u.name', 'u.email', 'u.phone', 's.nama as studio_name', 's.harga_per_jam', 's.kapasitas', 's.deskripsi')
            ->first();

        if (!$booking) {
            Session::flash('error', 'Booking tidak ditemukan.');
            return redirect('/admin/booking');
        }

        // Hitung durasi dan total harga
        $jam_mulai = strtotime($booking->jam_mulai);
        $jam_selesai = strtotime($booking->jam_selesai);
        $durasi_jam = round(($jam_selesai - $jam_mulai) / 3600, 1);
        $total_harga = $durasi_jam * $booking->harga_per_jam;

        return view('admin.booking_show', compact('booking', 'durasi_jam', 'total_harga'));
    }

    // SETUJU BOOKING (status: pending -> disetujui)
    public function approve($id)
    {
        if (!Session::get('login') || Session::get('role') != 'admin') {
            Session::flash('error', 'Silakan login sebagai admin terlebih dahulu.');
            return redirect('/login');
        }

        $booking = DB::table('booking_studio')->where('id', $id)->first();

        if (!$booking) {
            Session::flash('error', 'Booking tidak ditemukan.');
            return redirect('/admin/booking');
        }

        if ($booking->status_booking != 'pending') {
            Session::flash('error', 'Booking sudah disetujui atau dibatalkan.');
            return redirect('/admin/booking');
        }

        DB::table('booking_studio')->where('id', $id)->update([
            'status_booking' => 'disetujui',
            'updated_at' => now()
        ]);

        Session::flash('success', 'Booking berhasil disetujui!');
        return redirect('/admin/booking');
    }

    // BATALKAN BOOKING
    public function cancel($id)
    {
        if (!Session::get('login') || Session::get('role') != 'admin') {
            Session::flash('error', 'Silakan login sebagai admin terlebih dahulu.');
            return redirect('/login');
        }

        $booking = DB::table('booking_studio')->where('id', $id)->first();

        if (!$booking) {
            Session::flash('error', 'Booking tidak ditemukan.');
            return redirect('/admin/booking');
        }

        DB::table('booking_studio')->where('id', $id)->update([
            'status_booking' => 'dibatalkan',
            'updated_at' => now()
        ]);

        Session::flash('success', 'Booking berhasil dibatalkan!');
        return redirect('/admin/booking');
    }

    // SELESAIKAN BOOKING (status: disetujui -> selesai)
    public function complete($id)
    {
        if (!Session::get('login') || Session::get('role') != 'admin') {
            Session::flash('error', 'Silakan login sebagai admin terlebih dahulu.');
            return redirect('/login');
        }

        $booking = DB::table('booking_studio')->where('id', $id)->first();

        if (!$booking) {
            Session::flash('error', 'Booking tidak ditemukan.');
            return redirect('/admin/booking');
        }

        if ($booking->status_booking != 'disetujui') {
            Session::flash('error', 'Hanya booking yang disetujui dapat diselesaikan.');
            return redirect('/admin/booking');
        }

        DB::table('booking_studio')->where('id', $id)->update([
            'status_booking' => 'selesai',
            'updated_at' => now()
        ]);

        Session::flash('success', 'Booking telah diselesaikan!');
        return redirect('/admin/booking');
    }

    // HAPUS BOOKING
    public function destroy($id)
    {
        if (!Session::get('login') || Session::get('role') != 'admin') {
            Session::flash('error', 'Silakan login sebagai admin terlebih dahulu.');
            return redirect('/login');
        }

        $booking = DB::table('booking_studio')->where('id', $id)->first();

        if (!$booking) {
            Session::flash('error', 'Booking tidak ditemukan.');
            return redirect('/admin/booking');
        }

        DB::table('booking_studio')->where('id', $id)->delete();

        Session::flash('success', 'Booking berhasil dihapus!');
        return redirect('/admin/booking');
    }

    // FILTER BOOKING BERDASARKAN STATUS
    public function filter($status)
    {
        if (!Session::get('login') || Session::get('role') != 'admin') {
            Session::flash('error', 'Silakan login sebagai admin terlebih dahulu.');
            return redirect('/login');
        }

        $validStatus = ['pending', 'disetujui', 'selesai', 'dibatalkan'];
        
        if (!in_array($status, $validStatus)) {
            Session::flash('error', 'Status tidak valid.');
            return redirect('/admin/booking');
        }

        $bookings = DB::table('booking_studio as b')
            ->join('users as u', 'b.user_id', '=', 'u.id')
            ->join('studio as s', 'b.studio_id', '=', 's.id')
            ->where('b.status_booking', $status)
            ->select('b.*', 'u.name as customer_name', 'u.email', 's.nama as studio_name', 's.harga_per_jam')
            ->orderBy('b.created_at', 'desc')
            ->paginate(10);

        return view('admin.booking_index', compact('bookings', 'status'));
    }

    // STATISTIK BOOKING (Untuk Dashboard)
    public static function getStats()
    {
        $total = DB::table('booking_studio')->count();
        $pending = DB::table('booking_studio')->where('status_booking', 'pending')->count();
        $approved = DB::table('booking_studio')->where('status_booking', 'disetujui')->count();
        $completed = DB::table('booking_studio')->where('status_booking', 'selesai')->count();

        return [
            'total' => $total,
            'pending' => $pending,
            'approved' => $approved,
            'completed' => $completed
        ];
    }
}