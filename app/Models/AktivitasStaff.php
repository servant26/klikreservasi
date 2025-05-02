<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktivitasStaff extends Model
{
    use HasFactory;

    protected $table = 'aktivitas_staff';

    protected $fillable = ['ajuan_id', 'status_lama', 'status_baru'];

    public function ajuan()
    {
        return $this->belongsTo(Ajuan::class);
    }
}
