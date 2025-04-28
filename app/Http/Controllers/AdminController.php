<?php

namespace App\Http\Controllers;

use App\Models\Ajuan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Total semua ajuan bulan ini
        $totalAjuan = Ajuan::whereMonth('tanggal', Carbon::now()->month)
                           ->whereYear('tanggal', Carbon::now()->year)
                           ->count();

        // Reservasi Aula (jenis = 1, status = 1, bulan ini)
        $reservasi = Ajuan::where('jenis', 1)
                        ->whereMonth('created_at', Carbon::now()->month)
                        ->whereYear('created_at', Carbon::now()->year)
                        ->count();

        // Kunjungan Perpustakaan (jenis = 2, status = 1, bulan ini)
        $kunjungan = Ajuan::where('jenis', 2)
                        ->whereMonth('created_at', Carbon::now()->month)
                        ->whereYear('created_at', Carbon::now()->year)
                        ->count();

        return view('admin.dashboard', compact('totalAjuan', 'reservasi', 'kunjungan'));
    }
}
