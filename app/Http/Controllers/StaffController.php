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
        ->orderBy('created_at', 'desc')
        ->get();
        $reschedule = DB::table('ajuan')->where('status', 3)->count();
    
        $reservasi = DB::table('ajuan')
            ->where('jenis', '1')
            ->where('status', 1)
            ->count();
        
        $kunjungan = DB::table('ajuan')
            ->where('jenis', '2')
            ->where('status', 1)
            ->count();
        return view('staff.dashboard', compact('ajuan', 'reschedule', 'reservasi', 'kunjungan'));
    }

    public function tambah()
    {
        return view('staff.tambah'); // Assuming you have this view
    }
}
