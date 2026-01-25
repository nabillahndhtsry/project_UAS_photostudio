<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('login');
    }

    // Menampilkan form register
    public function showRegisterForm()
    {
        return view('register');
    }

    // Proses registrasi (SESUAI STRUCTURE TABEL USERS)
    public function register(Request $request)
    {
        // Validasi input sesuai struktur tabel
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:100',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|min:10|max:15',
            'address' => 'nullable|max:255',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ], [
            'name.required' => 'Nama lengkap harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok'
        ]);

        if ($validator->fails()) {
            return redirect('/register')
                ->withErrors($validator)
                ->withInput();
        }

        // Simpan data user baru SESUAI STRUKTUR TABEL
        $userId = DB::table('users')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => 'customer', // default role
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Auto login setelah registrasi
        $user = DB::table('users')->where('id', $userId)->first();

        // Cek apakah ada intended URL (dari booking)
        $intendedUrl = session('intended_url');
        
        // Simpan data ke session
        Session::put('user_id', $user->id);
        Session::put('name', $user->name);
        Session::put('email', $user->email);
        Session::put('role', $user->role);
        Session::put('login', TRUE);

        // Jika ada intended URL, redirect ke sana
        if ($intendedUrl) {
            session()->forget('intended_url');
            return redirect($intendedUrl)->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->name);
        }

        // Jika registrasi tanpa intended URL, ke welcome
        return redirect('/')->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->name);
    }

    // Proses login (SESUAI STRUCTURE TABEL)
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Ambil data user dari database menggunakan Query Builder
        $user = DB::table('users')
                ->where('email', $request->email)
                ->first();

        // Cek apakah user ada dan password cocok
        if ($user && Hash::check($request->password, $user->password)) {
            // Cek apakah ada intended URL (dari booking) SEBELUM update session
            $intendedUrl = session('intended_url');
            
            // Simpan data user ke session
            Session::put('user_id', $user->id);
            Session::put('name', $user->name);
            Session::put('email', $user->email);
            Session::put('role', $user->role);
            Session::put('login', TRUE);

            // Jika ada intended URL, redirect ke sana
            if ($intendedUrl) {
                session()->forget('intended_url');
                return redirect($intendedUrl)->with('success', 'Login berhasil!');
            }

            // Jika login tanpa intended URL
            if ($user->role == 'admin') {
                // Admin ke admin dashboard
                return redirect('/admin/dashboard')->with('success', 'Login berhasil sebagai Admin!');
            } else {
                // Customer ke welcome/home
                return redirect('/')->with('success', 'Login berhasil!');
            }
        } else {
            // Jika login gagal
            Session::flash('error', 'Email atau Password salah, tolong cek kembali...');
            return redirect('/login');
        }
    }

    // Logout
    public function logout()
    {
        // Hapus semua session
        Session::flush();
        
        // Redirect ke halaman login
        Session::flash('message', 'Logout berhasil!');
        return redirect('/login');
    }
}