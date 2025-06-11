<?php

namespace App\Http\Controllers;

use App\Models\Ajuan;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('period', 'bulan');
    
        $query = Ajuan::query();
    
        // Filter waktu utama
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
    
        $totalAjuan = $query->count();
        $reservasi = $query->clone()->where('jenis', 1)->count();
        $kunjungan = $query->clone()->where('jenis', 2)->count();
    
        $chartData = [
            'total' => $totalAjuan,
            'reservasi' => $reservasi,
            'kunjungan' => $kunjungan,
        ];
    
        // ======== Dynamic Line Chart Based on Period =========
        $labels = [];
        $reservasiData = [];
        $kunjunganData = [];
    
        switch ($period) {
            case 'hari':
                // Per jam (24 jam)
                for ($i = 0; $i < 24; $i++) {
                    $labels[] = sprintf('%02d:00', $i);
                    $reservasiData[] = Ajuan::where('jenis', 1)
                        ->whereDate('tanggal', Carbon::today())
                        ->whereHour('jam', $i)
                        ->count();
                    $kunjunganData[] = Ajuan::where('jenis', 2)
                        ->whereDate('tanggal', Carbon::today())
                        ->whereHour('jam', $i)
                        ->count();
                }
                break;
    
            case 'minggu':
                // Per hari dalam seminggu
                $weekDays = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
                $start = Carbon::now()->startOfWeek();
                foreach ($weekDays as $i => $dayName) {
                    $date = $start->copy()->addDays($i);
                    $labels[] = $dayName;
                    $reservasiData[] = Ajuan::where('jenis', 1)->whereDate('tanggal', $date)->count();
                    $kunjunganData[] = Ajuan::where('jenis', 2)->whereDate('tanggal', $date)->count();
                }
                break;
    
            case 'bulan':
                // Per minggu dalam bulan ini
                $start = Carbon::now()->startOfMonth();
                for ($i = 0; $i < 5; $i++) {
                    $weekStart = $start->copy()->addWeeks($i);
                    $weekEnd = $weekStart->copy()->endOfWeek();
                    if ($weekStart->month != Carbon::now()->month) break;
    
                    $labels[] = 'Minggu ' . ($i + 1);
                    $reservasiData[] = Ajuan::where('jenis', 1)->whereBetween('tanggal', [$weekStart, $weekEnd])->count();
                    $kunjunganData[] = Ajuan::where('jenis', 2)->whereBetween('tanggal', [$weekStart, $weekEnd])->count();
                }
                break;
    
            case 'semester':
            case 'tahun':
            case 'semua':
            default:
                // Per bulan
                $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                for ($m = 1; $m <= 12; $m++) {
                    $reservasiData[] = Ajuan::where('jenis', 1)
                        ->whereMonth('tanggal', $m)
                        ->whereYear('tanggal', Carbon::now()->year)
                        ->count();
                    $kunjunganData[] = Ajuan::where('jenis', 2)
                        ->whereMonth('tanggal', $m)
                        ->whereYear('tanggal', Carbon::now()->year)
                        ->count();
                }
                break;
        }
    
        $lineChart = [
            'labels' => $labels,
            'reservasi' => $reservasiData,
            'kunjungan' => $kunjunganData,
        ];
    
        return view('admin.dashboard', compact(
            'totalAjuan', 'reservasi', 'kunjungan',
            'chartData', 'lineChart', 'period'
        ));
    }

    public function datatable(Request $request)
    {
        $filter = $request->input('filter', 'bulan');
        $query = DB::table('ajuan')
            ->join('users', 'ajuan.user_id', '=', 'users.id')
            ->select('ajuan.*', 'users.name as nama', 'users.whatsapp', 'users.asal')
            ->where('ajuan.status', 2); // hanya status 2 (yang sudah ditanggapi)
    
        $now = now();
    
        switch ($filter) {
            case 'hari':
                $query->whereDate('ajuan.tanggal', $now->toDateString());
                break;
            case 'minggu':
                $query->whereBetween('ajuan.tanggal', [$now->startOfWeek(), $now->endOfWeek()]);
                break;
            case 'bulan':
                $query->whereMonth('ajuan.tanggal', $now->month)
                    ->whereYear('ajuan.tanggal', $now->year);
                break;
            case 'semester':
                $semesterStart = $now->month <= 6 ? $now->startOfYear() : $now->copy()->month(7)->startOfMonth();
                $semesterEnd   = $now->month <= 6 ? $now->copy()->month(6)->endOfMonth() : $now->endOfYear();
                $query->whereBetween('ajuan.tanggal', [$semesterStart, $semesterEnd]);
                break;
            case 'tahun':
                $query->whereYear('ajuan.tanggal', $now->year);
                break;
            case 'semua':
                // Tidak difilter
                break;
        }
    
        $ajuan = $query->orderBy('ajuan.tanggal', 'asc')->get();
    
        $reschedule = DB::table('ajuan')->where('status', 3)->count();
        $history = DB::table('ajuan')->where('status', 2)->count();
    
        $reservasi = DB::table('ajuan')
            ->where('jenis', 1)
            ->where('status', 1)
            ->count();
    
        $kunjungan = DB::table('ajuan')
            ->where('jenis', 2)
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
    
        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function manageEmployee()
    {
        $staffs = User::where('role', 'staff')->get();
        return view('admin.management', compact('staffs'));
    }
    
    public function storeStaff(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ], [
            'email.unique' => 'Email telah terdaftar',
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Masukkan email yang valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
        ]);
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'staff',
        ]);
    
        return redirect()->route('admin.management')->with('success', 'Staff berhasil ditambahkan');
    }
    
    public function deleteStaff($id)
    {
        $staff = User::where('role', 'staff')->findOrFail($id);
        $staff->delete();
    
        return redirect()->route('admin.management')->with('success', 'Staff telah dihapus');
    }
}

