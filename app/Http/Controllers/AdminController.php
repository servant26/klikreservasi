<?php

namespace App\Http\Controllers;

use App\Models\Ajuan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('period', 'bulan'); // default period is 'bulan'
    
        $query = Ajuan::query();
    
        // Filter berdasarkan periode waktu
        switch ($period) {
            case 'hari':
                $query->whereDate('tanggal', Carbon::today());
                break;
            case 'minggu':
                $query->whereBetween('tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'bulan':
                $query->whereMonth('tanggal', Carbon::now()->month)
                      ->whereYear('tanggal', Carbon::now()->year);
                break;
            case 'semester':
                $query->whereMonth('tanggal', '>=', Carbon::now()->subMonths(6)->month)
                      ->whereYear('tanggal', Carbon::now()->year);
                break;
            case 'tahun':
                $query->whereYear('tanggal', Carbon::now()->year);
                break;
            default:
                break;
        }
    
        // Menghitung jumlah ajuan berdasarkan jenis
        $totalAjuan = $query->count();
        $reservasi = $query->where('jenis', 1)->count();
        $kunjungan = $query->where('jenis', 2)->count();
    
        return view('admin.dashboard', compact('totalAjuan', 'reservasi', 'kunjungan', 'period'));
    }
    
}
