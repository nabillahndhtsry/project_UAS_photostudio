<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingStudio extends Model
{
    //
    protected $table = 'booking_studio';
    protected $fillable = ['user_id', 'studio_id', 'tanggal', 'jam_mulai', 'jam_selesai', 'total_harga', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }
}
