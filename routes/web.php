<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerBookingController; // ← TAMBAH INI
use App\Http\Controllers\CustomerDashboardController; // ← TAMBAH INI

// ==================== HALAMAN UTAMA ====================
Route::get('/', [CustomerBookingController::class, 'indexWelcome'])->name('welcome');

// ==================== AUTHENTICATION ====================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== DASHBOARD REDIRECT ====================
Route::get('/dashboard', function () {
    if (!Session::get('login')) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }
    
    if (Session::get('role') == 'admin') {
        return redirect('/admin/dashboard');
    } else {
        return redirect('/customer/dashboard');
    }
})->name('dashboard');

// ==================== CUSTOMER ROUTES ====================
// Dashboard Customer
Route::get('/customer/dashboard', [CustomerDashboardController::class, 'index'])
    ->name('customer.dashboard');

// Profile Customer
Route::get('/customer/profile', [CustomerDashboardController::class, 'profile'])
    ->name('customer.profile');
Route::post('/customer/profile/update', [CustomerDashboardController::class, 'updateProfile'])
    ->name('customer.profile.update');

// Studio untuk Customer
Route::get('/customer/studio', [CustomerBookingController::class, 'listStudio'])
    ->name('customer.studio.list');
Route::get('/customer/studio/{id}', [CustomerBookingController::class, 'showStudio'])
    ->name('customer.studio.show');

// Booking untuk Customer
Route::get('/customer/booking', [CustomerBookingController::class, 'bookingHistory'])
    ->name('customer.booking.history');
Route::get('/customer/booking/{id}', [CustomerBookingController::class, 'bookingDetail'])
    ->name('customer.booking.detail');
Route::post('/customer/booking/{id}/cancel', [CustomerBookingController::class, 'cancelBooking'])
    ->name('customer.booking.cancel');

// Booking Process
Route::get('/customer/studio/{id}/booking', [CustomerBookingController::class, 'createBooking'])
    ->name('customer.booking.create');
Route::post('/customer/booking/store', [CustomerBookingController::class, 'storeBooking'])
    ->name('customer.booking.store');

// ==================== PAYMENT CUSTOMER (SEDERHANAKAN) ====================
Route::get('/customer/pembayaran', function () {
    if (!Session::get('login')) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }
    
    $userId = Session::get('user_id');
    
    // Ambil booking terbaru untuk user
    $latestBooking = DB::table('booking_studio as b')
        ->join('studio as s', 'b.studio_id', '=', 's.id')
        ->where('b.user_id', $userId)
        ->where('b.status_booking', 'pending') // hanya yang pending
        ->orderBy('b.created_at', 'desc')
        ->first();
    
    if (!$latestBooking) {
        return redirect()->route('customer.dashboard')
            ->with('info', 'Tidak ada booking yang memerlukan pembayaran.');
    }
    
    // Hitung total
    $jam_mulai = strtotime($latestBooking->jam_mulai);
    $jam_selesai = strtotime($latestBooking->jam_selesai);
    $durasi_jam = round(($jam_selesai - $jam_mulai) / 3600, 1);
    $total_bayar = $durasi_jam * $latestBooking->harga_per_jam;
    
    // Data untuk view
    $bookingData = [
        'id' => $latestBooking->id,
        'studio_name' => $latestBooking->nama,
        'tanggal' => date('d M Y', strtotime($latestBooking->tanggal_booking)),
        'jam_mulai' => date('H:i', strtotime($latestBooking->jam_mulai)),
        'jam_selesai' => date('H:i', strtotime($latestBooking->jam_selesai)),
        'durasi' => $durasi_jam . ' jam',
        'harga_per_jam' => $latestBooking->harga_per_jam,
        'total' => $total_bayar,
        'kode_booking' => 'BK' . str_pad($latestBooking->id, 4, '0', STR_PAD_LEFT),
        'status' => 'Menunggu Pembayaran'
    ];
    
    return view('customer.pembayaran', compact('bookingData'));
})->name('customer.pembayaran');

// Tambahkan setelah route GET pembayaran:
Route::post('/customer/pembayaran/process', function(Illuminate\Http\Request $request) {
    // LOG: Cek apakah function dipanggil
    //\Log::info('Pembayaran process dipanggil', $request->all());
    
    if (!Session::get('login')) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }
    
    // LOG: Session user
   // \Log::info('User ID: ' . Session::get('user_id'));
    
    $metode_bayar = $request->metode_bayar;
    
    // Validasi metode pembayaran
    $request->validate([
        'booking_id' => 'required|exists:booking_studio,id',
        'metode_bayar' => 'required|in:transfer,ewallet,tunai',
    ]);
    
    // Validasi bukti pembayaran jika transfer atau e-wallet
    if (in_array($metode_bayar, ['transfer', 'ewallet'])) {
        $request->validate([
            'bukti_pembayaran' => 'required|file|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);
    }
    
    // LOG: Setelah validasi
    //\Log::info('Validasi berhasil', [
      //  'booking_id' => $request->booking_id,
        //'metode_bayar' => $request->metode_bayar
    //]);
    
    // Cek apakah pembayaran untuk booking_id ini sudah ada
    $existingPayment = DB::table('pembayaran')
        ->where('booking_id', $request->booking_id)
        ->first();
    
    //\Log::info('Existing payment:', (array) $existingPayment);
    
    // Handle file upload
    $bukti_pembayaran = null;
    if ($request->hasFile('bukti_pembayaran') && in_array($metode_bayar, ['transfer', 'ewallet'])) {
        $file = $request->file('bukti_pembayaran');
        $filename = 'bukti_' . $request->booking_id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/bukti_pembayaran', $filename);
        $bukti_pembayaran = 'bukti_pembayaran/' . $filename;
    }
    
    if ($existingPayment) {
        // Update pembayaran yang sudah ada
        $updateData = [
            'metode_bayar' => $request->metode_bayar,
            'status_bayar' => 'belum_lunas',
            'updated_at' => now()
        ];
        
        if ($bukti_pembayaran) {
            $updateData['bukti_pembayaran'] = $bukti_pembayaran;
        }
        
        DB::table('pembayaran')->where('booking_id', $request->booking_id)->update($updateData);
    } else {
        // Buat pembayaran baru (fallback)
        DB::table('pembayaran')->insert([
            'booking_id' => $request->booking_id,
            'total_bayar' => 0, // default, nanti bisa dihitung
            'metode_bayar' => $request->metode_bayar,
            'bukti_pembayaran' => $bukti_pembayaran,
            'status_bayar' => 'belum_lunas',
            'tanggal_bayar' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
    
    // Redirect ke invoice
    return redirect()->route('customer.invoice', ['id' => $request->booking_id])
        ->with('success', 'Pembayaran berhasil! Silakan cetak atau unduh invoice.');
})->name('customer.payment.process');

// Invoice pembayaran
Route::get('/customer/invoice/{id}', function($bookingId) {
    if (!Session::get('login')) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    $userId = Session::get('user_id');
    $userRole = Session::get('role');
    $dashboardRoute = $userRole === 'admin' ? '/admin/dashboard' : '/customer/dashboard';
    $errorRedirectRoute = $userRole === 'admin' ? '/admin/pembayaran' : '/customer/dashboard';

    // Ambil data booking dengan relasi
    $query = DB::table('booking_studio as b')
        ->join('studio as s', 'b.studio_id', '=', 's.id')
        ->join('users as u', 'b.user_id', '=', 'u.id')
        ->where('b.id', $bookingId);

    // Jika customer, hanya bisa lihat booking mereka sendiri
    // Jika admin, bisa lihat semua booking
    if ($userRole !== 'admin') {
        $query->where('b.user_id', $userId);
    }

    $booking = $query->first();

    if (!$booking) {
        return redirect($errorRedirectRoute)->with('error', 'Invoice tidak ditemukan.');
    }

    // Ambil data pembayaran
    $pembayaran = DB::table('pembayaran')
        ->where('booking_id', $bookingId)
        ->first();

    if (!$pembayaran) {
        return redirect($errorRedirectRoute)->with('error', 'Data pembayaran tidak ditemukan.');
    }

    // Hitung durasi dan total
    $jam_mulai = strtotime($booking->jam_mulai);
    $jam_selesai = strtotime($booking->jam_selesai);
    $durasi_jam = round(($jam_selesai - $jam_mulai) / 3600, 1);
    $total_harga = $durasi_jam * $booking->harga_per_jam;

    // Data booking
    $bookingData = [
        'id' => $booking->id,
        'kode_booking' => 'BK' . str_pad($booking->id, 4, '0', STR_PAD_LEFT),
        'studio_name' => $booking->nama,
        'tanggal' => date('d M Y', strtotime($booking->tanggal_booking)),
        'jam_mulai' => date('H:i', strtotime($booking->jam_mulai)),
        'jam_selesai' => date('H:i', strtotime($booking->jam_selesai)),
        'durasi' => $durasi_jam . ' jam',
        'harga_per_jam' => $booking->harga_per_jam,
        'total' => $total_harga,
    ];

    // Data customer
    $customerData = [
        'name' => $booking->name,
        'email' => $booking->email,
        'phone' => $booking->phone,
    ];

    // Data pembayaran
    $paymentData = [
        'id' => $pembayaran->id,
        'metode_bayar' => $pembayaran->metode_bayar,
        'status_bayar' => $pembayaran->status_bayar,
        'tanggal_bayar' => $pembayaran->tanggal_bayar,
    ];

    return view('customer.invoice', compact('bookingData', 'customerData', 'paymentData', 'userRole'));
})->name('customer.invoice');

// ==================== ADMIN ROUTES ====================
Route::prefix('admin')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', function () {
        if (!Session::get('login')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        if (Session::get('role') != 'admin') {
            return redirect('/dashboard')->with('error', 'Akses hanya untuk admin.');
        }
        
        // Total Studio
        $total_studio = DB::table('studio')->count();
        
        // Booking Hari Ini
        $booking_hari_ini = DB::table('booking_studio')
            ->whereDate('tanggal_booking', today())
            ->count();
        
        // Pending Payment (Pembayaran yang belum lunas)
        $pending_payment = DB::table('pembayaran')
            ->where('status_bayar', 'belum_lunas')
            ->count();
        
        return view('admin.dashboard', compact(
            'total_studio',
            'booking_hari_ini', 
            'pending_payment'
        ));
    })->name('admin.dashboard');
    
    // ========== STUDIO MANAGEMENT ==========
    Route::get('/studio', [StudioController::class, 'index'])->name('admin.studio.index');
    Route::get('/studio/tambah', [StudioController::class, 'create'])->name('admin.studio.create');
    Route::post('/studio/tambah', [StudioController::class, 'store'])->name('admin.studio.store');
    Route::get('/studio/edit/{id}', [StudioController::class, 'edit'])->name('admin.studio.edit');
    Route::post('/studio/update/{id}', [StudioController::class, 'update'])->name('admin.studio.update');
    Route::post('/studio/hapus/{id}', [StudioController::class, 'destroy'])->name('admin.studio.destroy'); // UBAH KE POST!
    
    // ========== BOOKING MANAGEMENT ==========
    Route::get('/booking', [BookingController::class, 'index'])->name('admin.booking.index');
    Route::get('/booking/{id}', [BookingController::class, 'show'])->name('admin.booking.show');
    Route::post('/booking/approve/{id}', [BookingController::class, 'approve'])->name('admin.booking.approve'); // POST
    Route::post('/booking/cancel/{id}', [BookingController::class, 'cancel'])->name('admin.booking.cancel'); // POST
    Route::post('/booking/complete/{id}', [BookingController::class, 'complete'])->name('admin.booking.complete'); // POST
    Route::post('/booking/delete/{id}', [BookingController::class, 'destroy'])->name('admin.booking.destroy'); // POST
    Route::get('/booking/filter/{status}', [BookingController::class, 'filter'])->name('admin.booking.filter');
    
    // ========== PAYMENT MANAGEMENT ==========
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('admin.pembayaran.index');
    Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])->name('admin.pembayaran.show');
    Route::post('/pembayaran/confirm/{id}', [PembayaranController::class, 'confirm'])->name('admin.pembayaran.confirm'); // POST
    Route::get('/pembayaran/filter/{status}', [PembayaranController::class, 'filter'])->name('admin.pembayaran.filter');
    
    // ========== CUSTOMER MANAGEMENT ==========
    Route::get('/customer', [CustomerController::class, 'index'])->name('admin.customer.index');
    Route::get('/customer/filter', [CustomerController::class, 'filter'])->name('admin.customer.filter');
});