<?php

namespace App\Http\Controllers;

use App\Models\Ajuan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('period', 'bulan'); // default: bulan

        $query = Ajuan::query();

        // Filter waktu berdasarkan periode
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
                $query->whereBetween('tanggal', [
                    Carbon::now()->subMonths(6)->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ]);
                break;
            case 'tahun':
                $query->whereYear('tanggal', Carbon::now()->year);
                break;
            case 'semua':
            default:
                // no filter
                break;
        }

        // Hitung total dan berdasarkan jenis (1: reservasi, 2: kunjungan)
        $totalAjuan = $query->count();
        $reservasi = $query->clone()->where('jenis', 1)->count();
        $kunjungan = $query->clone()->where('jenis', 2)->count();

        // Pie & Bar Chart data (terpengaruh filter)
        $chartData = [
            'total' => $totalAjuan,
            'reservasi' => $reservasi,
            'kunjungan' => $kunjungan,
        ];

        // Line Chart data (tidak terpengaruh filter, tetap 1 tahun penuh)
        $lineData = Ajuan::select(
                DB::raw('MONTH(tanggal) as month'),
                DB::raw('SUM(CASE WHEN jenis = 1 THEN 1 ELSE 0 END) as reservasi'),
                DB::raw('SUM(CASE WHEN jenis = 2 THEN 1 ELSE 0 END) as kunjungan')
            )
            ->whereYear('tanggal', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = range(1, 12);
        $monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $monthlyReservasi = [];
        $monthlyKunjungan = [];

        foreach ($months as $m) {
            $monthData = $lineData->firstWhere('month', $m);
            $monthlyReservasi[] = $monthData ? $monthData->reservasi : 0;
            $monthlyKunjungan[] = $monthData ? $monthData->kunjungan : 0;
        }

        $lineChart = [
            'labels' => $monthLabels,
            'reservasi' => $monthlyReservasi,
            'kunjungan' => $monthlyKunjungan,
        ];

        return view('admin.dashboard', compact(
            'totalAjuan', 'reservasi', 'kunjungan',
            'chartData', 'lineChart', 'period'
        ));
    }
}
