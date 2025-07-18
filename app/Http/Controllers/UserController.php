<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ajuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $ajuan = Ajuan::with('user') // relasi ke tabel users
                    ->where('user_id', Auth::id()) // hanya ajuan milik user yang login
                    ->whereDate('tanggal', '>=', Carbon::today()) // filter tanggal hari ini dan seterusnya
                    ->orderBy('tanggal', 'asc') // urutkan berdasarkan tanggal
                    ->get();

        return view('user.dashboard', compact('ajuan'));
    }   

    public function reservasi()
    {
        $user = Auth::user(); 
        $jenis = 1;

        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        $tanggalList = [];

        for ($date = $start->copy(); $date <= $end; $date->addDay()) {
            if ($date->isWeekday()) {
                $tanggalList[] = [
                    'date' => $date->format('Y-m-d'),
                    'label' => $date->translatedFormat('l, d F Y'),
                ];
            }
        }

        $ajuanAcc = Ajuan::with('user')
            ->where('jenis', $jenis)
            ->where('status', 2)
            ->get()
            ->groupBy('tanggal');

        return view('user.reservasi', compact('user', 'jenis', 'tanggalList', 'ajuanAcc'));
    }


    
    public function kunjungan()
    {
        $user = Auth::user(); 
        $jenis = 2; // 2 = kunjungan
    
        // Ambil ajuan milik user lain, jenis kunjungan, tanggal hari ini ke atas
        $ajuan = Ajuan::where('user_id', '!=', $user->id)
                    ->where('jenis', $jenis)
                    ->whereDate('tanggal', '>=', Carbon::today())
                    ->orderBy('tanggal', 'asc')
                    ->get();
    
        return view('user.kunjungan', compact('user', 'jenis', 'ajuan'));
    } 

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'jumlah_orang' => 'required|integer|min:1',
            'tanggal' => 'required|string',
            'jam' => 'required|string',
            'jenis' => 'required|in:1,2',
            'surat' => 'required|file|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'required|string',
        ], [
            'surat.required' => 'File surat wajib diupload.',
            'surat.file' => 'File surat harus berupa file yang valid.',
            'surat.mimes' => 'File surat harus berupa gambar berformat JPG,JPEG,PNG.',
            'surat.max' => 'Ukuran file surat maksimal 2048 KB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $jumlah_orang = (int) $request->input('jumlah_orang');
        $jenis = (int) $request->input('jenis');

        if ($jenis === 1 && $jumlah_orang > 100) {
            return redirect()->back()->withErrors(['jumlah_orang' => 'Jumlah maksimal untuk reservasi aula adalah 100 orang'])->withInput();
        }

        try {
            $tanggalInput = $request->input('tanggal');

            if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $tanggalInput)) {
                // Format dd/mm/yyyy
                $tanggal = Carbon::createFromFormat('d/m/Y', $tanggalInput)->format('Y-m-d');
            } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggalInput)) {
                // Format yyyy-mm-dd
                $tanggal = Carbon::createFromFormat('Y-m-d', $tanggalInput)->format('Y-m-d');
            } else {
                return redirect()->back()->withErrors(['tanggal' => 'Format tanggal tidak valid'])->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['tanggal' => 'Format tanggal tidak valid'])->withInput();
        }


        $jam = $request->input('jam');
        $hari = Carbon::parse($tanggal)->dayOfWeek;

        // Cek tanggal sudah lewat
        if (Carbon::parse($tanggal)->lt(Carbon::today())) {
            return redirect()->back()->withErrors(['tanggal' => 'Tidak bisa membuat ajuan untuk tanggal yang sudah lewat'])->withInput();
        }

        // Cek akhir pekan
        if ($hari == 0 || $hari == 6) {
            return redirect()->back()->withErrors(['tanggal' => 'Ajuan hanya bisa dibuat pada hari kerja (Senin - Jumat)'])->withInput();
        }

        // Cek jam operasional
        if ($hari >= 1 && $hari <= 4 && ($jam < '08:00' || $jam > '16:00')) {
            return redirect()->back()->withErrors(['jam' => 'Jam reservasi untuk Senin-Kamis hanya antara 08:00 - 16:00'])->withInput();
        } elseif ($hari == 5 && ($jam < '08:00' || $jam > '15:00')) {
            return redirect()->back()->withErrors(['jam' => 'Jam reservasi untuk Jumat hanya antara 08:00 - 15:00'])->withInput();
        }

        // Cek hari libur nasional (yang tanggalnya fix setiap tahun)
        $liburFix = ['01-01', '01-05', '17-08', '25-12'];
        $formatBulanHari = Carbon::parse($tanggal)->format('d-m');

        if (in_array($formatBulanHari, $liburFix)) {
            return redirect()->back()->withErrors(['tanggal' => 'Tanggal yang dipilih adalah hari libur nasional, silahkan ajukan untuk tgl lain'])->withInput();
        }

        // Upload file surat
        $fileName = null;
        if ($request->hasFile('surat')) {
            $file = $request->file('surat');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/surat'), $fileName);
        }

        Ajuan::create([
            'user_id' => Auth::id(),
            'jumlah_orang' => $jumlah_orang,
            'jenis' => $jenis,
            'tanggal' => $tanggal,
            'jam' => $jam,
            'surat' => $fileName,
            'deskripsi' => $request->input('deskripsi'),
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Ajuan berhasil dibuat!');
    }

    public function edit($id)
    {
        $ajuan = DB::table('ajuan')
            ->join('users', 'ajuan.user_id', '=', 'users.id')
            ->select('ajuan.*', 'users.name', 'users.email', 'users.whatsapp', 'users.asal')
            ->where('ajuan.id', $id)
            ->first();

        if (!$ajuan) {
            return redirect()->route('user.dashboard')->with('error', 'Data tidak ditemukan.');
        }

        // Ambil ajuan lain yang jenisnya sama, bukan milik user sendiri, dan tanggal hari ini ke atas
        $ajuanLain = Ajuan::where('user_id', '!=', $ajuan->user_id)
            ->where('jenis', $ajuan->jenis)
            ->whereDate('tanggal', '>=', Carbon::today())
            ->orderBy('tanggal', 'asc')
            ->with('user')
            ->get();

        // Generate seluruh tanggal hari kerja dalam bulan ini
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $tanggalList = [];

        foreach (Carbon::parse($startOfMonth)->daysUntil($endOfMonth) as $tanggal) {
            if (!$tanggal->isWeekend()) {
                $tanggalList[] = [
                    'date' => $tanggal->format('Y-m-d'),
                    'label' => $tanggal->translatedFormat('l, d F Y') // Contoh: Senin, 27 Juli 2025
                ];
            }
        }

        // Ambil data ajuan yang disetujui untuk tanggal-tanggal di bulan ini
        $tanggalArray = array_column($tanggalList, 'date');

        $ajuanAcc = Ajuan::whereIn('tanggal', $tanggalArray)
            ->where('jenis', 1)
            ->where('status', 2)
            ->with('user')
            ->get()
            ->groupBy('tanggal');

        return view('user.edit', compact('ajuan', 'ajuanLain', 'tanggalList', 'ajuanAcc'));
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah_orang' => 'required|integer|min:1',
            'tanggal' => 'required|string',
            'jam' => 'required|date_format:H:i',
            'jenis' => 'required|in:1,2',
            'deskripsi' => 'required|string|max:500',
            'surat' => 'nullable|file|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'surat.file' => 'File surat harus berupa file yang valid.',
            'surat.image' => 'File surat harus berupa gambar.',
            'surat.mimes' => 'File surat harus berupa gambar berformat JPG, JPEG, atau PNG.',
            'surat.max' => 'Ukuran file surat maksimal 2048 KB.',
        ]);

        $jumlahOrang = (int) $request->jumlah_orang;
        $jenis = (int) $request->jenis;

        if ($jenis === 1 && $jumlahOrang > 100) {
            return back()->withErrors(['jumlah_orang' => 'Maksimal 100 orang untuk reservasi aula.'])->withInput();
        } elseif ($jenis === 2 && $jumlahOrang > 50) {
            return back()->withErrors(['jumlah_orang' => 'Maksimal 50 orang untuk kunjungan perpustakaan.'])->withInput();
        }

        $ajuan = DB::table('ajuan')->where('id', $id)->first();
        if (!$ajuan) {
            return redirect()->route('user.dashboard')->with('error', 'Data tidak ditemukan.');
        }

        try {
            if ($request->jenis == 1) {
                // Tombol tanggal kirim dalam format Y-m-d
                $tanggalInput = Carbon::createFromFormat('Y-m-d', $request->tanggal);
            } else {
                // Datepicker biasa (dd/mm/yyyy)
                $tanggalInput = Carbon::createFromFormat('d/m/Y', $request->tanggal);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['tanggal' => 'Format tanggal tidak valid.'])->withInput();
        }

        // Validasi tanggal tidak boleh ke belakang
        if ($tanggalInput->isPast() && !$tanggalInput->isToday()) {
            return back()->withErrors(['tanggal' => 'Tanggal tidak boleh kurang dari hari ini.'])->withInput();
        }

        // Cek hari libur nasional fix (yang tanggalnya sama setiap tahun)
        $liburFix = ['01-01', '01-05', '17-08', '25-12'];
        $formatBulanHari = $tanggalInput->format('d-m');
        if (in_array($formatBulanHari, $liburFix)) {
            return back()->withErrors(['tanggal' => 'Tanggal yang dipilih adalah hari libur nasional, silahkan ajukan untuk tgl lain.'])->withInput();
        }

        // Validasi akhir pekan
        $dayOfWeek = $tanggalInput->dayOfWeek;
        if ($dayOfWeek == 0 || $dayOfWeek == 6) {
            return back()->withErrors(['tanggal' => 'Hanya bisa ajukan di hari kerja (Senin–Jumat).'])->withInput();
        }

        // Validasi jam berdasarkan hari
        $jamInput = $request->jam;
        if ($dayOfWeek >= 1 && $dayOfWeek <= 4) {
            if ($jamInput < '08:00' || $jamInput > '16:00') {
                return back()->withErrors(['jam' => 'Jam reservasi Senin–Kamis: 08:00–16:00.'])->withInput();
            }
        } elseif ($dayOfWeek == 5) {
            if ($jamInput < '08:00' || $jamInput > '15:00') {
                return back()->withErrors(['jam' => 'Jam reservasi Jumat: 08:00–15:00.'])->withInput();
            }
        }

        // Persiapan data update
        $dataToUpdate = [
            'jumlah_orang' => $jumlahOrang,
            'jenis' => $jenis,
            'tanggal' => $tanggalInput->format('Y-m-d'),
            'jam' => $jamInput,
            'status' => 3,
            'deskripsi' => $request->deskripsi,
            'updated_at' => now(),
        ];

        // Ganti file surat jika ada
        if ($request->hasFile('surat')) {
            if ($ajuan->surat) {
                $oldFilePath = public_path('uploads/surat/' . $ajuan->surat);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $filename = time() . '_' . $request->file('surat')->getClientOriginalName();
            $request->file('surat')->move(public_path('uploads/surat'), $filename);
            $dataToUpdate['surat'] = $filename;
        }

        $updated = DB::table('ajuan')->where('id', $id)->update($dataToUpdate);

        return redirect()->route('user.dashboard')->with(
            $updated ? 'success' : 'error',
            $updated ? 'Data berhasil diperbarui.' : 'Gagal memperbarui data.'
        );
    }
    
    public function destroy($id)
    {
        $ajuan = \App\Models\Ajuan::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        
        // Cek jika ada surat yang terupload dan hapus file-nya
        if ($ajuan->surat) {
            $suratPath = public_path('uploads/surat/' . $ajuan->surat);
            if (file_exists($suratPath)) {
                unlink($suratPath); // Menghapus file surat
            }
        }
    
        $ajuan->delete();
    
        return redirect()->route('user.dashboard')->with('success', 'Ajuan berhasil dibatalkan.');
    }    
    
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }
    
    public function editProfile()
    {
        $user = Auth::user();
        return view('user.edit-profile', compact('user'));
    }
    
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'whatsapp' => 'nullable|string|max:20',
            'asal' => 'nullable|string|max:100',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
    
        // Normalisasi WhatsApp ke format 0815xxxxxx
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
    
        $user->name = $request->name;
        $user->email = $request->email;
        $user->whatsapp = $normalizedWhatsapp;
        $user->asal = $request->asal;
    
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
    
        $user->save();
    
        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}    