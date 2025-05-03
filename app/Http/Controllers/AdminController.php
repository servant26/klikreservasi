<?php

namespace App\Http\Controllers;

use App\Models\Ajuan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function datatable()
    {
        $ajuan = DB::table('ajuan')
            ->join('users', 'ajuan.user_id', '=', 'users.id')
            ->select('ajuan.*', 'users.name as nama', 'users.whatsapp', 'users.asal')
            ->where('ajuan.status', 2)
            ->orderBy('ajuan.tanggal', 'asc')
            ->get();
    
        $reschedule = DB::table('ajuan')->where('status', 3)->count();

        $history = DB::table('ajuan')->where('status', 2)->count();
    
        $reservasi = DB::table('ajuan')
            ->where('jenis', 1)  // 1 untuk reservasi
            ->where('status', 1)
            ->count();    
    
        $kunjungan = DB::table('ajuan')
            ->where('jenis', 2)  // 2 untuk kunjungan
            ->where('status', 1)
            ->count();
        return view('admin.datatable', compact('ajuan', 'reschedule', 'history', 'kunjungan', 'reservasi'));
    }
    
    public function editProfile()
    {
        $admin = Auth::user();
        return view('admin.edit-profile', compact('admin'));
    }
    
    public function updateProfile(Request $request)
    {
        $admin = Auth::user();
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'whatsapp' => 'nullable|string|max:20',
            'asal' => 'nullable|string|max:100',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
    
        // Normalisasi nomor WhatsApp
        $normalizedWhatsapp = null;
        if ($request->filled('whatsapp')) {
            $rawWhatsapp = preg_replace('/[^0-9]/', '', $request->whatsapp);
    
            if (str_starts_with($rawWhatsapp, '62')) {
                $normalizedWhatsapp = '0' . substr($rawWhatsapp, 2);
            } elseif (str_starts_with($rawWhatsapp, '8')) {
                $normalizedWhatsapp = '0' . $rawWhatsapp;
            } elseif (str_starts_with($rawWhatsapp, '0')) {
                $normalizedWhatsapp = $rawWhatsapp;
            } else {
                $normalizedWhatsapp = $rawWhatsapp;
            }
        }
    
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->whatsapp = $normalizedWhatsapp;
        $admin->asal = $request->asal;
    
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }
    
        $admin->save();
    
        return redirect()->route('admin.dashboard')->with('success', 'Profil berhasil diperbarui.');
    }
}
