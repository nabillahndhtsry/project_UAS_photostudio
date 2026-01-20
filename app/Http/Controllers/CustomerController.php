<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    // LIST CUSTOMER (Hanya role customer)
    public function index()
    {
        if (!Session::get('login') || Session::get('role') != 'admin') {
            Session::flash('error', 'Silakan login sebagai admin terlebih dahulu.');
            return redirect('/login');
        }

        // Ambil hanya user dengan role 'customer'
        $customers = DB::table('users')
            ->where('role', 'customer')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.customer_index', compact('customers'));
    }

    // FILTER CUSTOMER BERDASARKAN TANGGAL DAFTAR
    public function filter(Request $request)
    {
        if (!Session::get('login') || Session::get('role') != 'admin') {
            Session::flash('error', 'Silakan login sebagai admin terlebih dahulu.');
            return redirect('/login');
        }

        $query = DB::table('users')->where('role', 'customer');

        // Filter berdasarkan tanggal
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%");
            });
        }

        $customers = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.customer_index', compact('customers'));
    }

    // STATISTIK CUSTOMER (Untuk Dashboard)
    public static function getStats()
    {
        $total = DB::table('users')->where('role', 'customer')->count();
        $today = DB::table('users')
            ->where('role', 'customer')
            ->whereDate('created_at', today())
            ->count();
        $month_count = DB::table('users')
            ->where('role', 'customer')
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        return [
            'total' => $total,
            'today' => $today,
            'this_month' => $month_count
        ];
    }
}