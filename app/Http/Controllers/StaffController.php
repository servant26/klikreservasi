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
        ->orderBy('tanggal', 'desc')
        ->get();
        $reschedule = DB::table('ajuan')->where('status', 3)->count();

        $kunjungan = DB::table('ajuan')
            ->where('jenis', '1')
            ->where('status', 1)
            ->count();    

        $reservasi = DB::table('ajuan')
            ->where('jenis', '2')
            ->where('status', 1)
            ->count();

        return view('staff.dashboard', compact('ajuan', 'reschedule', 'kunjungan', 'reservasi'));
    }

    public function updateStatus($id)
    {
        // Menggunakan Query Builder untuk mengupdate status hanya jika status 1 atau 3
        $updated = DB::table('ajuan')
            ->where('id', $id)
            ->whereIn('status', [1, 3])  // Hanya ubah jika status 1 atau 3
            ->update(['status' => 2]);  // Ubah status menjadi 2 (Sudah ditanggapi)
    
        // Cek apakah update berhasil
        if ($updated) {
            return redirect()->route('staff.dashboard')->with('success', 'Status berhasil diubah!');
        }
    
        // Jika update gagal (misal data tidak ditemukan atau status tidak cocok)
        return redirect()->route('staff.dashboard')->with('error', 'Gagal mengubah status!');
    }

    // private function formatWhatsAppNumber($number)
    // {
    //     // Remove any non-numeric characters
    //     $number = preg_replace('/\D/', '', $number);
    
    //     // Check the number format
    //     if (strpos($number, '+62') === 0) {
    //         return $number; // Already in the correct format
    //     } elseif (strpos($number, '62') === 0) {
    //         return $number; // Starts with 62, no changes needed
    //     } elseif (strpos($number, '08') === 0) {
    //         return '62' . substr($number, 1); // Replace leading 08 with 62
    //     } elseif (strpos($number, '8') === 0) {
    //         return '62' . $number; // Prepend 62 to leading 8
    //     }
    
    //     // Return the original number if no matches
    //     return $number;
    // } 

    // public function tambah()
    // {
    //     return view('staff.tambah'); // Assuming you have this view
    // }

    // public function store(Request $request)
    // {
    //     // Validasi data input
    //     $request->validate([
    //         'nama' => 'required|string|max:255',
    //         'asal' => 'required|string|max:255',
    //         'nomor_wa' => 'required|string|max:20',
    //         'jumlah_orang' => 'required|integer',
    //         'jenis' => 'required|string',
    //         'tanggal' => 'required|date',
    //         'jam' => 'required|date_format:H:i',
    //     ]);
    //     $userId = auth()->id();
    //     // Insert data ke tabel `ajuan` menggunakan Query Builder
    //     DB::table('ajuan')->insert([
    //         'nama' => $request->input('nama'),
    //         'asal' => $request->input('asal'),
    //         'whatsapp' => $this->formatWhatsAppNumber($request->input('nomor_wa')),
    //         'jumlah_orang' => $request->input('jumlah_orang'),
    //         'jenis' => $request->input('jenis'),
    //         'tanggal' => $request->input('tanggal'),
    //         'jam' => $request->input('jam'),
    //         'status' => 2, // Default status, bisa disesuaikan
    //         'user_id' => $userId, // Menambahkan user_id
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ]);

    //     // Redirect dengan pesan sukses
    //     return redirect()->route('staff.dashboard')->with('success', 'Data berhasil ditambahkan.');
    // }

    // public function edit($id)
    // {
    //     // Ambil data berdasarkan ID
    //     $ajuan = DB::table('ajuan')->where('id', $id)->first();

    //     // Periksa apakah data ditemukan
    //     if (!$ajuan) {
    //         return redirect()->route('staff.dashboard')->with('error', 'Data tidak ditemukan.');
    //     }

    //     return view('staff.edit', compact('ajuan'));
    // }

    // public function update(Request $request, $id)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'nama' => 'required|string|max:255',
    //         'asal' => 'required|string|max:255',
    //         'nomor_wa' => 'required|string|max:20',
    //         'jumlah_orang' => 'required|integer',
    //         'jenis' => 'required|string',
    //         'tanggal' => 'required|date',
    //         'jam' => 'required|date_format:H:i',
    //     ]);

    //     // Update data
    //     DB::table('ajuan')
    //         ->where('id', $id)
    //         ->update([
    //             'nama' => $request->nama,
    //             'asal' => $request->asal,
    //             'whatsapp' => $this->formatWhatsAppNumber($request->input('nomor_wa')),
    //             'jumlah_orang' => $request->jumlah_orang,
    //             'jenis' => $request->jenis === 'Kunjungan' ? 1 : 2,
    //             'tanggal' => $request->tanggal,
    //             'jam' => $request->jam,
    //             'status' => 3, // Nilai default
    //             'updated_at' => now(),
    //         ]);

    //     return redirect()->route('staff.dashboard')->with('success', 'Data berhasil diperbarui.');
    // }

    public function reschedule()
    {
        $reschedule = DB::table('ajuan')->where('status', 3)->get();
        return view('staff.reschedule', compact('reschedule'));
    }

    public function kunjungan()
    {
        $kunjungan = DB::table('ajuan')
                        ->where('jenis', 1) 
                        ->where('status', 1) 
                        ->get();
        return view('staff.kunjungan', compact('kunjungan'));
    }

    public function reservasi()
    {
        $reservasi = DB::table('ajuan')
                        ->where('jenis', 2) 
                        ->where('status', 1) 
                        ->get();
        return view('staff.reservasi', compact('reservasi'));
    }

    public function saran()
    {
        return view('staff.saran'); // Assuming you have this view
    }
}