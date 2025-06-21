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
            ->select('ajuan.*', 'users.name as nama', 'users.whatsapp', 'users.asal')
            ->where('ajuan.status', '!=', 4); // << INI baris penting
    
        $now = now();
    
        switch ($filter) {
            case 'menunggu':
                $query->whereIn('ajuan.status', [1, 3]);
                break;
            case 'ditanggapi':
                $query->where('ajuan.status', 2);
                break;
            case 'hari':
                $query->whereDate('ajuan.tanggal', $now->toDateString());
                break;
            case 'minggu':
                $startOfWeek = now()->copy()->startOfWeek();
                $endOfWeek = now()->copy()->endOfWeek();
                $query->whereBetween('ajuan.tanggal', [$startOfWeek->toDateString(), $endOfWeek->toDateString()]);
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
    if ($ajuan->status != 2) {
        return redirect()->back()->with('error', 'Hanya ajuan yang sudah ditanggapi yang bisa dibatalkan!');
    }

    if ($ajuan->surat_balasan) {
        $filePath = public_path($ajuan->surat_balasan);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    $updated = DB::table('ajuan')->where('id', $id)->update([
        'status' => 1,
        'surat_balasan' => null,
        'updated_at' => now(),
    ]);

    if ($updated) {
        AktivitasStaff::create([
            'ajuan_id' => $id,
            'status_lama' => 2,
            'status_baru' => 1,
        ]);

        return redirect()->back()->with('success', 'Status berhasil dibatalkan dan surat balasan dihapus!');
    }

    return redirect()->back()->with('error', 'Gagal mengubah status!');
}


public function handleAction(Request $request)
{
    $id = $request->id;
    $action = $request->action;

    $ajuan = DB::table('ajuan')->where('id', $id)->first();

    if (!$ajuan) {
        return response()->json(['success' => false, 'message' => 'Ajuan tidak ditemukan!']);
    }

    $statusBaru = null;

    if ($action === 'accept') {
        $statusBaru = 2;
    } elseif ($action === 'reject') {
        $statusBaru = 4;
    } else {
        return response()->json(['success' => false, 'message' => 'Aksi tidak valid!']);
    }

    DB::table('ajuan')->where('id', $id)->update([
        'status' => $statusBaru,
        'updated_at' => now(),
    ]);

    AktivitasStaff::create([
        'ajuan_id' => $id,
        'status_lama' => $ajuan->status,
        'status_baru' => $statusBaru,
    ]);

    return response()->json(['success' => true, 'new_status' => $statusBaru]);
}


    public function showBalasForm($id)
    {
        $ajuan = DB::table('ajuan')
            ->join('users', 'ajuan.user_id', '=', 'users.id')
            ->select('ajuan.*', 'users.name as nama', 'users.whatsapp', 'users.asal')
            ->where('ajuan.id', $id)
            ->first();

        if (!$ajuan) {
            return redirect()->route('staff.dashboard')->with('error', 'Ajuan tidak ditemukan!');
        }

        return view('staff.balas', compact('ajuan'));
    }

public function submitBalasan(Request $request, $id)
{
    $ajuan = DB::table('ajuan')->where('id', $id)->first();

    if (!$ajuan) return redirect()->back()->with('error', 'Ajuan tidak ditemukan!');

    // Validasi file jika diupload
    $validated = $request->validate([
        'surat_balasan' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ], [
        'surat_balasan.required' => 'Surat balasan wajib diupload.',
        'surat_balasan.image' => 'File harus berupa gambar.',
        'surat_balasan.mimes' => 'File harus berupa format jpg, jpeg, atau png.',
        'surat_balasan.max' => 'File maksimal berukuran 2048KB.',
    ]);

    $updateData = [
        'status' => 2, // ubah status jadi 2
        'updated_at' => now(),
    ];

    if ($request->hasFile('surat_balasan')) {
        $filename = time() . '_' . $request->file('surat_balasan')->getClientOriginalName();
        $request->file('surat_balasan')->move(public_path('uploads/surat'), $filename);
        $updateData['surat_balasan'] = 'uploads/surat/' . $filename;
    }

    DB::table('ajuan')->where('id', $id)->update($updateData);

    // Simpan aktivitas (optional)
    \App\Models\AktivitasStaff::create([
        'ajuan_id' => $id,
        'status_lama' => $ajuan->status,
        'status_baru' => 2,
    ]);

    return redirect()->route('staff.dashboard')->with('success', 'Balasan berhasil dikirim dan status diubah.');
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
                $startOfWeek = now()->copy()->startOfWeek();
                $endOfWeek = now()->copy()->endOfWeek();
                $query->whereBetween('ajuan.tanggal', [$startOfWeek->toDateString(), $endOfWeek->toDateString()]);
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
                $startOfWeek = now()->copy()->startOfWeek();
                $endOfWeek = now()->copy()->endOfWeek();
                $query->whereBetween('ajuan.tanggal', [$startOfWeek->toDateString(), $endOfWeek->toDateString()]);
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
                $startOfWeek = now()->copy()->startOfWeek();
                $endOfWeek = now()->copy()->endOfWeek();
                $query->whereBetween('ajuan.tanggal', [$startOfWeek->toDateString(), $endOfWeek->toDateString()]);
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
                ->get(); // Ambil semua data

    return view('staff.history', compact('aktivitas'));
}


public function restore($id)
{
    $aktivitas = AktivitasStaff::findOrFail($id);
    $ajuan = $aktivitas->ajuan;

    // Update status ajuan ke 1
    $ajuan->status = 1;
    $ajuan->save();

    // Hapus aktivitas ini dari log
    $aktivitas->delete();

    return redirect()->route('staff.history')->with('success', 'Ajuan berhasil direstore.');
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