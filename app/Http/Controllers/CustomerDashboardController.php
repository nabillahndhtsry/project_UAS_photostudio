<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CustomerDashboardController extends Controller
{
    // Dashboard Customer
    public function index()
    {
        if (!Session::get('login')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user_id = Session::get('user_id');
        
        // Statistik booking customer
        $stats = [
            'total_booking' => DB::table('booking_studio')->where('user_id', $user_id)->count(),
            'booking_aktif' => DB::table('booking_studio')
                ->where('user_id', $user_id)
                ->where('status_booking', 'disetujui')
                ->count(),
            'pending' => DB::table('booking_studio')
                ->where('user_id', $user_id)
                ->where('status_booking', 'pending')
                ->count(),
            'selesai' => DB::table('booking_studio')
                ->where('user_id', $user_id)
                ->where('status_booking', 'selesai')
                ->count()
        ];

        // Booking terbaru (5 data)
        $recent_bookings = DB::table('booking_studio as b')
            ->join('studio as s', 'b.studio_id', '=', 's.id')
            ->leftJoin('pembayaran as p', 'b.id', '=', 'p.booking_id')
            ->where('b.user_id', $user_id)
            ->select('b.*', 's.nama as studio_name', 's.gambar', 'p.status_bayar')
            ->orderBy('b.created_at', 'desc')
            ->limit(5)
            ->get();

        return view('customer.dashboard', compact('stats', 'recent_bookings'));
    }

    // Profil Customer
    public function profile()
    {
        if (!Session::get('login')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = DB::table('users')->where('id', Session::get('user_id'))->first();
        return view('customer.profile', compact('user'));
    }

    // Update Profil
    public function updateProfile(Request $request)
    {
        if (!Session::get('login')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'name' => 'required|min:3|max:100',
            'phone' => 'nullable|min:10|max:15',
            'address' => 'nullable|max:255'
        ]);

        DB::table('users')->where('id', Session::get('user_id'))->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'updated_at' => now()
        ]);

        // Update session
        Session::put('name', $request->name);

        return redirect('/customer/profile')->with('success', 'Profil berhasil diperbarui!');
    }
}