<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\AktivitasStaff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class StaffController extends Controller
{
    // Display the staff dashboard
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'bulan');
        $query = DB::table('ajuan')
            ->join('users', 'ajuan.user_id', '=', 'users.id')
            ->select('ajuan.*', 'users.name as nama', 'users.whatsapp', 'users.asal');
    
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
    
        return view('staff.dashboard', compact('ajuan', 'reschedule', 'history', 'kunjungan', 'reservasi'));
    }
    
    
    public function updateStatus($id)
    {
        $ajuan = DB::table('ajuan')->where('id', $id)->first();
    
        if (!$ajuan) return redirect()->back()->with('error', 'Ajuan tidak ditemukan!');
    
        $currentStatus = $ajuan->status;
        $newStatus = ($currentStatus == 2) ? 1 : 2;
    
        $updated = DB::table('ajuan')->where('id', $id)->update(['status' => $newStatus]);
    
        if ($updated) {
            // Catat aktivitasnya
            AktivitasStaff::create([
                'ajuan_id' => $id,
                'status_lama' => $currentStatus,
                'status_baru' => $newStatus,
            ]);
    
            return redirect()->back()->with('success', 'Status berhasil diubah!');
        }
    
        return redirect()->back()->with('error', 'Gagal mengubah status!');
    }
    public function kunjungan(Request $request)
    {
        $filter = $request->input('filter', 'bulan'); // default ke bulan ini
        $query = DB::table('ajuan')
            ->join('users', 'ajuan.user_id', '=', 'users.id')
            ->select('ajuan.*', 'users.name as nama', 'users.whatsapp', 'users.asal')
            ->where('ajuan.jenis', 2)
            ->whereIn('ajuan.status', [1, 2]);
    
        $now = now();
    
        switch ($filter) {
            case 'hari':
                $query->whereDate('ajuan.tanggal', $now->toDateString());
                break;
            case 'minggu':
                $query->whereBetween('ajuan.tanggal', [$now->startOfWeek(), $now->endOfWeek()]);
                break;
            case 'bulan':
                $query->whereMonth('ajuan.tanggal', $now->month)->whereYear('ajuan.tanggal', $now->year);
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
    
        $kunjungan = $query->orderBy('ajuan.tanggal', 'asc')->orderBy('ajuan.jam', 'asc')->get();
    
        return view('staff.kunjungan', compact('kunjungan'));
    }
    
    
    public function reschedule(Request $request)
    {
        $filter = $request->input('filter', 'bulan'); // default ke bulan ini
        $query = DB::table('ajuan')
            ->join('users', 'ajuan.user_id', '=', 'users.id')
            ->select('ajuan.*', 'users.name as nama', 'users.whatsapp', 'users.asal')
            ->where('ajuan.status', 3);
    
        $now = now();
    
        switch ($filter) {
            case 'hari':
                $query->whereDate('ajuan.tanggal', $now->toDateString());
                break;
            case 'minggu':
                $query->whereBetween('ajuan.tanggal', [$now->startOfWeek(), $now->endOfWeek()]);
                break;
            case 'bulan':
                $query->whereMonth('ajuan.tanggal', $now->month)->whereYear('ajuan.tanggal', $now->year);
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
    
        $reschedule = $query->orderBy('ajuan.tanggal', 'asc')->orderBy('ajuan.jam', 'asc')->get();
    
        return view('staff.reschedule', compact('reschedule'));
    }
    
    

    public function reservasi(Request $request)
    {
        $filter = $request->input('filter', 'bulan'); // default ke 'bulan'
        $query = DB::table('ajuan')
            ->join('users', 'ajuan.user_id', '=', 'users.id')
            ->select('ajuan.*', 'users.name as nama', 'users.whatsapp', 'users.asal')
            ->where('ajuan.jenis', 1)
            ->whereIn('ajuan.status', [1, 2]);
    
        $now = now();
    
        switch ($filter) {
            case 'hari':
                $query->whereDate('ajuan.tanggal', $now->toDateString());
                break;
            case 'minggu':
                $query->whereBetween('ajuan.tanggal', [
                    $now->startOfWeek(), $now->endOfWeek()
                ]);
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
                // No date filter
                break;
        }
    
        $reservasi = $query->orderBy('ajuan.tanggal', 'asc')->orderBy('ajuan.jam', 'asc')->get();
    
        return view('staff.reservasi', compact('reservasi'));
    }
    
    
    
    public function history()
    {
        $aktivitas = AktivitasStaff::with('ajuan.user')
                    ->latest()
                    ->get();
    
        return view('staff.history', compact('aktivitas'));
    }
    
  
    public function editProfile()
    {
        $staff = Auth::user();
        return view('staff.edit-profile', compact('staff'));
    }

    public function updateProfile(Request $request)
    {
        $staff = Auth::user();
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staff->id,
            'whatsapp' => 'nullable|string|max:20',
            'asal' => 'nullable|string|max:100',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
    
        // Normalisasi WhatsApp
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
    
        $staff->name = $request->name;
        $staff->email = $request->email;
        $staff->whatsapp = $normalizedWhatsapp;
        $staff->asal = $request->asal;
    
        if ($request->filled('password')) {
            $staff->password = bcrypt($request->password);
        }
    
        $staff->save();
    
        return redirect()->route('staff.profile')->with('success', 'Data berhasil dirubah');
    }
    

}