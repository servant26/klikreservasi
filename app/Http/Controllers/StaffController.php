<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class StaffController extends Controller
{
    // Display the staff dashboard
    public function index()
    {
        $ajuan = DB::table('ajuan')
            ->join('users', 'ajuan.user_id', '=', 'users.id')
            ->select('ajuan.*', 'users.name as nama', 'users.whatsapp', 'users.asal')
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
            
    
        return view('staff.dashboard', compact('ajuan', 'reschedule', 'history', 'kunjungan', 'reservasi'));
    }
    
    public function updateStatus($id)
    {
        $currentStatus = DB::table('ajuan')->where('id', $id)->value('status');
    
        // Toggle status logic
        if ($currentStatus == 2) {
            // Kembali ke status 'Belum ditanggapi' (default status 1)
            $newStatus = 1;
        } else {
            // Ubah status menjadi 'Sudah ditanggapi' (status 2)
            $newStatus = 2;
        }
    
        // Update status
        $updated = DB::table('ajuan')->where('id', $id)->update(['status' => $newStatus]);
    
        if ($updated) {
            return redirect()->back()->with('success', 'Status berhasil diubah!');
        }
    
        return redirect()->back()->with('error', 'Gagal mengubah status!');
    }

    public function reschedule()
    {
        $reschedule = DB::table('ajuan')
                        ->join('users', 'ajuan.user_id', '=', 'users.id')
                        ->select('ajuan.*', 'users.name as nama', 'users.whatsapp', 'users.asal')
                        ->where('ajuan.status', 3) // hanya status reschedule
                        ->orderBy('ajuan.tanggal', 'asc')
                        ->get();
    
        return view('staff.reschedule', compact('reschedule'));
    }
    
    public function kunjungan()
    {
        $kunjungan = DB::table('ajuan')
                        ->join('users', 'ajuan.user_id', '=', 'users.id')
                        ->select('ajuan.*', 'users.name as nama', 'users.whatsapp', 'users.asal')
                        ->where('ajuan.jenis', 2) // harusnya jenis 2 untuk kunjungan
                        ->whereIn('ajuan.status', [1, 2]) // hanya status 1 dan 2
                        ->orderBy('ajuan.tanggal', 'asc')
                        ->get();
    
        return view('staff.kunjungan', compact('kunjungan'));
    }
    
    public function reservasi()
    {
        $reservasi = DB::table('ajuan')
                        ->join('users', 'ajuan.user_id', '=', 'users.id')
                        ->select('ajuan.*', 'users.name as nama', 'users.whatsapp', 'users.asal')
                        ->where('ajuan.jenis', 1) // harusnya jenis 1 untuk reservasi
                        ->whereIn('ajuan.status', [1, 2]) // hanya status 1 dan 2
                        ->orderBy('ajuan.tanggal', 'asc')
                        ->get();
    
        return view('staff.reservasi', compact('reservasi'));
    }
    
    
    

    public function saran()
    {
        return view('staff.saran'); // Assuming you have this view
    }

    public function history()
    {
        $history = DB::table('ajuan')
                        ->join('users', 'ajuan.user_id', '=', 'users.id')
                        ->select('ajuan.*', 'users.name as nama', 'users.whatsapp', 'users.asal')
                        ->where('ajuan.status', 2)
                        ->orderBy('ajuan.tanggal', 'asc')
                        ->get();
    
        return view('staff.history', compact('history'));
    }

}