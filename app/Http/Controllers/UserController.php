<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Ambil seluruh data ajuan tanpa filter berdasarkan user_id
        $ajuan = DB::table('ajuan')
            ->orderBy('tanggal', 'desc')  // Urutkan berdasarkan tanggal terbaru
            ->get();  // Gunakan get() untuk mengambil banyak data
    
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

    public function tambah()
    {
        return view('user.tambah'); // Assuming you have this view
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'nama' => 'required|string|max:255',
            'asal' => 'required|string|max:255',
            'nomor_wa' => 'required|string|max:20',
            'jumlah_orang' => 'required|integer',
            'jenis' => 'required|string',
            'tanggal' => 'required|date',
            'jam' => 'required|date_format:H:i',
        ]);
    
        // Ambil ID user yang sedang login
        $userId = auth()->id();
    
        // Insert data ke tabel `ajuan` menggunakan Query Builder
        DB::table('ajuan')->insert([
            'nama' => $request->input('nama'),
            'asal' => $request->input('asal'),
            'whatsapp' => $this->formatWhatsAppNumber($request->input('nomor_wa')),
            'jumlah_orang' => $request->input('jumlah_orang'),
            'jenis' => $request->input('jenis'),
            'tanggal' => $request->input('tanggal'),
            'jam' => $request->input('jam'),
            'status' => 1, // Default status, bisa disesuaikan
            'user_id' => $userId, // Menambahkan user_id
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        // Redirect dengan pesan sukses
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