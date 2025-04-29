<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ajuan extends Model
{
    use HasFactory;

    protected $table = 'ajuan';

    protected $fillable = [
        'user_id',
        'jumlah_orang',
        'jenis',
        'tanggal',
        'jam',
        'status',
        'surat',       // tambahkan ini
        'deskripsi',   // tambahkan ini
    ];    

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

