<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Produk Model
 * 
 * Model Eloquent untuk tabel 'produks' di database
 * Digunakan untuk operasi database produk seperti create, read, update, delete
 */
class produk extends Model
{
    /**
     * Nama tabel di database
     * Secara default Laravel akan mencari tabel dengan nama plural dari class (produks)
     * Kita eksplisit mendefinisikan karena nama tabelnya sudah benar
     * 
     * 
     */
    protected $table = 'studio';
    protected $fillable = ['nama', 'deskripsi', 'harga_per_jam', 'gambar', 'status'];

}
