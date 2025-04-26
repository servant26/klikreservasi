<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ajuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $ajuan = Ajuan::with('user') // relasi ke tabel users
                    ->whereDate('tanggal', '>=', Carbon::today()) // filter tanggal hari ini dan seterusnya
                    ->orderBy('tanggal', 'asc') // urutkan berdasarkan tanggal
                    ->get();
        
        return view('user.dashboard', compact('ajuan'));
    }   
    
    private function formatWhatsAppNumber($number)
    {
        // Remove any non-numeric characters
        $number = preg_replace('/\D/', '', $number);
    
        // Check the number format
        if (strpos($number, '+62') === 0) {
            return $number; // Already in the correct format
        } elseif (strpos($number, '62') === 0) {
            return $number; // Starts with 62, no changes needed
        } elseif (strpos($number, '08') === 0) {
            return '62' . substr($number, 1); // Replace leading 08 with 62
        } elseif (strpos($number, '8') === 0) {
            return '62' . $number; // Prepend 62 to leading 8
        }
    
        // Return the original number if no matches
        return $number;
    }    

    // public function tambah()
    // {
    //     $user = Auth::user(); // Ambil user yang sedang login
    //     return view('user.tambah', compact('user'));
    // }

    public function reservasi()
    {
        $user = Auth::user(); 
        $jenis = 1; // 1 = reservasi
        return view('user.reservasi', compact('user', 'jenis'));
    }
    
    public function kunjungan()
    {
        $user = Auth::user(); 
        $jenis = 2; // 2 = kunjungan
        return view('user.kunjungan', compact('user', 'jenis'));
    }    

    public function store(Request $request)
    {
        $request->validate([
            'jumlah_orang' => 'required|integer',
            'jenis' => 'required|in:1,2', // Pastikan cuma 1 atau 2
            'tanggal' => 'required|date',
            'jam' => 'required|date_format:H:i',
        ]);
    
        Ajuan::create([
            'user_id' => Auth::id(),
            'jumlah_orang' => $request->jumlah_orang,
            'jenis' => $request->jenis, // Data jenis dikirim dari form
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
        ]);
    
        return redirect()->route('user.dashboard')->with('success', 'Data berhasil ditambahkan.');
    }
    

    public function edit($id)
    {
        // Ambil data berdasarkan ID
        $ajuan = DB::table('ajuan')->where('id', $id)->first();

        // Periksa apakah data ditemukan
        if (!$ajuan) {
            return redirect()->route('user.dashboard')->with('error', 'Data tidak ditemukan.');
        }

        return view('user.edit', compact('ajuan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'asal' => 'required|string|max:255',
            'nomor_wa' => 'required|string|max:20',
            'jumlah_orang' => 'required|string',
            'jenis' => 'required|string',
            'tanggal' => 'required|date',
            'jam' => 'required|date_format:H:i',
        ]);

        // Update data
        DB::table('ajuan')
            ->where('id', $id)
            ->update([
                'nama' => $request->nama,
                'asal' => $request->asal,
                'whatsapp' => $this->formatWhatsAppNumber($request->input('nomor_wa')),
                'jumlah_orang' => $request->jumlah_orang,
                'jenis' => $request->jenis === 'Kunjungan' ? 1 : 2,
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'status' => 3, // Nilai default
                'updated_at' => now(),
            ]);

        return redirect()->route('user.dashboard')->with('success', 'Data berhasil diperbarui.');
    }
    
}    