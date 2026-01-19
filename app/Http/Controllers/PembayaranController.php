<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PembayaranController extends Controller
{
    // LIST SEMUA PEMBAYARAN (Hanya lihat)
    public function index()
    {
        if (!Session::get('login') || Session::get('role') != 'admin') {
            Session::flash('error', 'Silakan login sebagai admin terlebih dahulu.');
            return redirect('/login');
        }

        // Ambil data pembayaran dengan join booking, studio, dan user
        $pembayaran = DB::table('pembayaran as p')
            ->join('booking_studio as b', 'p.booking_id', '=', 'b.id')
            ->join('studio as s', 'b.studio_id', '=', 's.id')
            ->join('users as u', 'b.user_id', '=', 'u.id')
            ->select(
                'p.*',
                'b.tanggal_booking',
                'b.jam_mulai',
                'b.jam_selesai',
                'b.status_booking',
                's.nama as studio_name',
                's.harga_per_jam',
                'u.name as customer_name',
                'u.email',
                'u.phone'
            )
            ->orderBy('p.created_at', 'desc')
            ->paginate(10);

        return view('admin.pembayaran_index', compact('pembayaran'));
    }

    // DETAIL PEMBAYARAN
    public function show($id)
    {
        if (!Session::get('login') || Session::get('role') != 'admin') {
            Session::flash('error', 'Silakan login sebagai admin terlebih dahulu.');
            return redirect('/login');
        }

        $pembayaran = DB::table('pembayaran as p')
            ->join('booking_studio as b', 'p.booking_id', '=', 'b.id')
            ->join('studio as s', 'b.studio_id', '=', 's.id')
            ->join('users as u', 'b.user_id', '=', 'u.id')
            ->where('p.id', $id)
            ->select(
                'p.*',
                'b.tanggal_booking',
                'b.jam_mulai',
                'b.jam_selesai',
                'b.status_booking',
                's.nama as studio_name',
                's.harga_per_jam',
                's.kapasitas',
                's.deskripsi',
                'u.name as customer_name',
                'u.email',
                'u.phone'
            )
            ->first();

        if (!$pembayaran) {
            Session::flash('error', 'Data pembayaran tidak ditemukan.');
            return redirect('/admin/pembayaran');
        }

        // Hitung durasi
        $durasi_jam = round((strtotime($pembayaran->jam_selesai) - strtotime($pembayaran->jam_mulai)) / 3600, 1);
        $total_harga = $durasi_jam * $pembayaran->harga_per_jam;

        return view('admin.pembayaran_show', compact('pembayaran', 'durasi_jam', 'total_harga'));
    }

    // KONFIRMASI PEMBAYARAN LUNAS (Hanya ini yang admin lakukan)
    public function confirm($id)
    {
        if (!Session::get('login') || Session::get('role') != 'admin') {
            Session::flash('error', 'Silakan login sebagai admin terlebih dahulu.');
            return redirect('/login');
        }

        $pembayaran = DB::table('pembayaran')->where('id', $id)->first();
        
        if (!$pembayaran) {
            Session::flash('error', 'Data pembayaran tidak ditemukan.');
            return redirect('/admin/pembayaran');
        }

        // Cek apakah sudah lunas
        if ($pembayaran->status_bayar == 'lunas') {
            Session::flash('info', 'Pembayaran sudah berstatus LUNAS.');
            return redirect('/admin/pembayaran');
        }

        // Update status menjadi lunas
        DB::table('pembayaran')->where('id', $id)->update([
            'status_bayar' => 'lunas',
            'tanggal_bayar' => now()->format('Y-m-d'), // Set tanggal konfirmasi
            'updated_at' => now()
        ]);

        Session::flash('success', 'Pembayaran berhasil dikonfirmasi sebagai LUNAS!');
        return redirect('/admin/pembayaran');
    }

    // FILTER PEMBAYARAN BERDASARKAN STATUS
    public function filter($status)
    {
        if (!Session::get('login') || Session::get('role') != 'admin') {
            Session::flash('error', 'Silakan login sebagai admin terlebih dahulu.');
            return redirect('/login');
        }

        $validStatus = ['lunas', 'belum_lunas'];
        
        if (!in_array($status, $validStatus)) {
            Session::flash('error', 'Status tidak valid.');
            return redirect('/admin/pembayaran');
        }

        $pembayaran = DB::table('pembayaran as p')
            ->join('booking_studio as b', 'p.booking_id', '=', 'b.id')
            ->join('studio as s', 'b.studio_id', '=', 's.id')
            ->join('users as u', 'b.user_id', '=', 'u.id')
            ->where('p.status_bayar', $status)
            ->select(
                'p.*',
                'b.tanggal_booking',
                'b.jam_mulai',
                'b.jam_selesai',
                's.nama as studio_name',
                'u.name as customer_name',
                'u.email'
            )
            ->orderBy('p.created_at', 'desc')
            ->paginate(10);

        return view('admin.pembayaran_index', compact('pembayaran', 'status'));
    }

    // STATISTIK PEMBAYARAN (Untuk Dashboard)
    public static function getStats()
    {
        $total = DB::table('pembayaran')->count();
        $lunas = DB::table('pembayaran')->where('status_bayar', 'lunas')->count();
        $belum_lunas = DB::table('pembayaran')->where('status_bayar', 'belum_lunas')->count();
        $total_pendapatan = DB::table('pembayaran')->where('status_bayar', 'lunas')->sum('total_bayar');

        return [
            'total' => $total,
            'lunas' => $lunas,
            'belum_lunas' => $belum_lunas,
            'total_pendapatan' => $total_pendapatan
        ];
    }
}