<?php

namespace App\Http\Controllers;

use App\Models\Ajuan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('period', 'bulan'); // default: bulan
    
        $baseQuery = Ajuan::query();
    
        // Filter berdasarkan periode waktu
        switch ($period) {
            case 'hari':
                $baseQuery->whereDate('tanggal', Carbon::today());
                break;
            case 'minggu':
                $baseQuery->whereBetween('tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'bulan':
                $baseQuery->whereMonth('tanggal', Carbon::now()->month)
                          ->whereYear('tanggal', Carbon::now()->year);
                break;
            case 'semester':
                $baseQuery->where('tanggal', '>=', Carbon::now()->subMonths(6)->startOfDay());
                break;
            case 'tahun':
                $baseQuery->whereYear('tanggal', Carbon::now()->year);
                break;
            case 'semuanya':
                // no filter
                break;
        }
    
        // Gunakan clone agar tidak saling menimpa
        $totalAjuan = (clone $baseQuery)->count();
        $reservasi = (clone $baseQuery)->where('jenis', 1)->count();
        $kunjungan = (clone $baseQuery)->where('jenis', 2)->count();
    
        return view('admin.dashboard', compact('totalAjuan', 'reservasi', 'kunjungan', 'period'));
    }
    
}