<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class StudioController extends Controller
{
    // ========== ADMIN FUNCTIONS ==========
    
    // LIST STUDIO (Admin)
    public function index()
    {
        // CEK SESSION ADMIN (sesuai Modul 4)
        if (!Session::get('login') || Session::get('role') != 'admin') {
            Session::flash('error', 'Silakan login sebagai admin terlebih dahulu.');
            return redirect('/login');
        }

        $studios = DB::table('studio')->orderBy('id', 'desc')->get();
        return view('admin.studio_index', compact('studios'));
    }

    // FORM TAMBAH STUDIO
    public function create()
    {
        if (!Session::get('login') || Session::get('role') != 'admin') {
            Session::flash('error', 'Silakan login sebagai admin terlebih dahulu.');
            return redirect('/login');
        }

        return view('admin.studio_create');
    }

    // PROSES TAMBAH STUDIO
    public function store(Request $request)
    {
        if (!Session::get('login') || Session::get('role') != 'admin') {
            Session::flash('error', 'Silakan login sebagai admin terlebih dahulu.');
            return redirect('/login');
        }

        $request->validate([
            'nama' => 'required|max:100',
            'harga_per_jam' => 'required|numeric|min:0',
            'kapasitas' => 'required|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = time() . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/studio'), $fileName);
            $gambarPath = 'images/studio/' . $fileName;
        }

        DB::table('studio')->insert([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga_per_jam' => $request->harga_per_jam,
            'kapasitas' => $request->kapasitas,
            'gambar' => $gambarPath,
            'fasilitas' => $request->fasilitas,
            'status' => $request->status ?? 'tersedia',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Session::flash('success', 'Studio berhasil ditambahkan!');
        return redirect('/admin/studio');
    }

    // FORM EDIT STUDIO
    public function edit($id)
    {
        if (!Session::get('login') || Session::get('role') != 'admin') {
            Session::flash('error', 'Silakan login sebagai admin terlebih dahulu.');
            return redirect('/login');
        }

        $studio = DB::table('studio')->where('id', $id)->first();
        
        if (!$studio) {
            Session::flash('error', 'Studio tidak ditemukan.');
            return redirect('/admin/studio');
        }

        return view('admin.studio_edit', compact('studio'));
    }

    // PROSES UPDATE STUDIO
    public function update(Request $request, $id)
    {
        if (!Session::get('login') || Session::get('role') != 'admin') {
            Session::flash('error', 'Silakan login sebagai admin terlebih dahulu.');
            return redirect('/login');
        }

        $request->validate([
            'nama' => 'required|max:100',
            'harga_per_jam' => 'required|numeric|min:0',
            'kapasitas' => 'required|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $studio = DB::table('studio')->where('id', $id)->first();
        
        if (!$studio) {
            Session::flash('error', 'Studio tidak ditemukan.');
            return redirect('/admin/studio');
        }

        $gambarPath = $studio->gambar;
        
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($studio->gambar && file_exists(public_path($studio->gambar))) {
                unlink(public_path($studio->gambar));
            }
            
            $file = $request->file('gambar');
            $fileName = time() . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/studio'), $fileName);
            $gambarPath = 'images/studio/' . $fileName;
        }

        DB::table('studio')->where('id', $id)->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga_per_jam' => $request->harga_per_jam,
            'kapasitas' => $request->kapasitas,
            'gambar' => $gambarPath,
            'fasilitas' => $request->fasilitas,
            'status' => $request->status,
            'updated_at' => now()
        ]);

        Session::flash('success', 'Studio berhasil diperbarui!');
        return redirect('/admin/studio');
    }

    // HAPUS STUDIO
    public function destroy($id)
    {
        if (!Session::get('login') || Session::get('role') != 'admin') {
            Session::flash('error', 'Silakan login sebagai admin terlebih dahulu.');
            return redirect('/login');
        }

        $studio = DB::table('studio')->where('id', $id)->first();
        
        if (!$studio) {
            Session::flash('error', 'Studio tidak ditemukan.');
            return redirect('/admin/studio');
        }

        // Hapus gambar jika ada
        if ($studio->gambar && file_exists(public_path($studio->gambar))) {
            unlink(public_path($studio->gambar));
        }

        DB::table('studio')->where('id', $id)->delete();

        Session::flash('success', 'Studio berhasil dihapus!');
        return redirect('/admin/studio');
    }

    // ========== CUSTOMER FUNCTIONS ==========
    
    // LIST STUDIO UNTUK CUSTOMER
    public function listForCustomer()
    {
        $studios = DB::table('studio')
                    ->where('status', 'tersedia')
                    ->orderBy('nama')
                    ->get();
        
        return view('customer.studio_list', compact('studios'));
    }

    // DETAIL STUDIO UNTUK CUSTOMER
    public function show($id)
    {
        $studio = DB::table('studio')
            ->where('id', $id)
            ->first();
        
        if (!$studio) {
            return redirect()->route('customer.studios')
                ->with('error', 'Studio tidak ditemukan.');
        }
        
        return view('customer.studio_detail', compact('studio'));
    }
    
}