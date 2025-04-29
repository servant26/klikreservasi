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
                    ->whereDate('tanggal', '>=', Carbon::today()) // filter tanggal hari ini dan seterusnya
                    ->orderBy('tanggal', 'asc') // urutkan berdasarkan tanggal
                    ->get();
        
        return view('user.dashboard', compact('ajuan'));
    }   
      
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
        // Ambil semua input
        $input = $request->all();

        // Validasi input awal
        $validator = Validator::make($input, [
            'jumlah_orang' => 'required|integer|min:1',
            'tanggal' => 'required|string',
            'jam' => 'required|string',
            'jenis' => 'required|in:1,2',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Validasi jumlah_orang maksimal berdasarkan jenis
        $jumlah_orang = (int) $request->input('jumlah_orang');
        $jenis = (int) $request->input('jenis');

        if ($jenis === 1 && $jumlah_orang > 100) {
            return redirect()->back()->withErrors(['jumlah_orang' => 'Jumlah maksimal untuk reservasi aula adalah 100 orang'])->withInput();
        } elseif ($jenis === 2 && $jumlah_orang > 50) {
            return redirect()->back()->withErrors(['jumlah_orang' => 'Jumlah maksimal untuk kunjungan perpustakaan adalah 50 orang'])->withInput();
        }

        // Ubah tanggal dari d/m/Y ke Y-m-d
        try {
            $tanggal = Carbon::createFromFormat('d/m/Y', $request->input('tanggal'))->format('Y-m-d');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['tanggal' => 'Format tanggal tidak valid'])->withInput();
        }

        $jam = $request->input('jam');

        // Cek 1: Tidak boleh ajukan untuk hari kemarin
        if (Carbon::parse($tanggal)->lt(Carbon::today())) {
            return redirect()->back()->withErrors(['tanggal' => 'Tidak bisa membuat ajuan untuk tanggal yang sudah lewat'])->withInput();
        }

        // Cek 2: Tidak boleh ajukan di hari Sabtu atau Minggu
        $hari = Carbon::parse($tanggal)->dayOfWeek;
        if ($hari == 0 || $hari == 6) {
            return redirect()->back()->withErrors(['tanggal' => 'Ajuan hanya bisa dibuat pada hari kerja (Senin - Jumat)'])->withInput();
        }

        // Cek 3: Validasi jam operasional
        if ($hari >= 1 && $hari <= 4) {
            if ($jam < '08:00' || $jam > '16:00') {
                return redirect()->back()->withErrors(['jam' => 'Jam reservasi untuk Senin-Kamis hanya antara 08:00 - 16:00'])->withInput();
            }
        } elseif ($hari == 5) {
            if ($jam < '08:00' || $jam > '15:00') {
                return redirect()->back()->withErrors(['jam' => 'Jam reservasi untuk Jumat hanya antara 08:00 - 15:00'])->withInput();
            }
        }

        // Cek 4: Tidak boleh ada duplikasi tanggal+jam
        $exists = Ajuan::where('tanggal', $tanggal)
            ->where('jam', $jam)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['jam' => 'Sudah ada ajuan di tanggal dan jam tersebut'])->withInput();
        }

        // Simpan data
        Ajuan::create([
            'user_id' => Auth::id(),
            'jumlah_orang' => $jumlah_orang,
            'jenis' => $jenis,
            'tanggal' => $tanggal,
            'jam' => $jam,
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Ajuan berhasil dibuat!');
    }
    public function edit($id)
    {
        $ajuan = DB::table('ajuan')
            ->join('users', 'ajuan.user_id', '=', 'users.id')
            ->select('ajuan.*', 'users.name', 'users.email', 'users.whatsapp')
            ->where('ajuan.id', $id)
            ->first();
    
        if (!$ajuan) {
            return redirect()->route('user.dashboard')->with('error', 'Data tidak ditemukan.');
        }
    
        return view('user.edit', compact('ajuan'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah_orang' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'jam' => 'required|date_format:H:i',
            'jenis' => 'required|in:1,2',
        ]);
    
        // Ambil nilai jumlah_orang dan jenis
        $jumlahOrang = (int) $request->jumlah_orang;
        $jenis = (int) $request->jenis;
    
        // Validasi jumlah orang maksimal
        if ($jenis === 1 && $jumlahOrang > 100) {
            return back()->withErrors(['jumlah_orang' => 'Jumlah maksimal untuk reservasi aula adalah 100 orang.'])->withInput();
        } elseif ($jenis === 2 && $jumlahOrang > 50) {
            return back()->withErrors(['jumlah_orang' => 'Jumlah maksimal untuk kunjungan perpustakaan adalah 50 orang.'])->withInput();
        }
    
        $ajuan = DB::table('ajuan')->where('id', $id)->first();
    
        if (!$ajuan) {
            return redirect()->route('user.dashboard')->with('error', 'Data tidak ditemukan.');
        }
    
        // Ubah format tanggal ke Carbon
        $tanggalInput = Carbon::parse($request->input('tanggal'));
        $jamInput = $request->input('jam');
    
        // Validasi tidak boleh tanggal kemarin
        if ($tanggalInput->isPast() && !$tanggalInput->isToday()) {
            return back()->withErrors(['tanggal' => 'Tanggal tidak boleh kurang dari hari ini.'])->withInput();
        }
    
        // Validasi hari kerja dan jam kerja
        $dayOfWeek = $tanggalInput->dayOfWeek;
    
        if ($dayOfWeek == 0 || $dayOfWeek == 6) {
            return back()->withErrors(['tanggal' => 'Ajuan hanya bisa dilakukan pada hari kerja (Senin sampai Jumat).'])->withInput();
        }
    
        if ($dayOfWeek >= 1 && $dayOfWeek <= 4) {
            if ($jamInput < '08:00' || $jamInput > '16:00') {
                return back()->withErrors(['jam' => 'Jam reservasi Senin-Kamis hanya antara 08:00 sampai 16:00.'])->withInput();
            }
        } elseif ($dayOfWeek == 5) {
            if ($jamInput < '08:00' || $jamInput > '15:00') {
                return back()->withErrors(['jam' => 'Jam reservasi pada Jumat hanya antara 08:00 sampai 15:00.'])->withInput();
            }
        }
    
        // Cek duplikasi (abaikan dirinya sendiri)
        $existing = DB::table('ajuan')
            ->where('tanggal', $tanggalInput->format('Y-m-d'))
            ->where('jam', $jamInput)
            ->where('id', '!=', $id)
            ->first();
    
        if ($existing) {
            return back()->withErrors(['tanggal' => 'Sudah ada reservasi pada tanggal dan jam tersebut.'])->withInput();
        }
    
        // Update data
        $updated = DB::table('ajuan')
            ->where('id', $id)
            ->update([
                'jumlah_orang' => $jumlahOrang,
                'jenis' => $jenis,
                'tanggal' => $tanggalInput->format('Y-m-d'),
                'jam' => $jamInput,
                'status' => 3,
                'updated_at' => now(),
            ]);
    
        if ($updated) {
            return redirect()->route('user.dashboard')->with('success', 'Data berhasil diperbarui.');
        } else {
            return redirect()->route('user.dashboard')->with('error', 'Gagal memperbarui data.');
        }
    }
    
    public function destroy($id)
    {
        $ajuan = \App\Models\Ajuan::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $ajuan->delete();
    
        // Mengarahkan kembali ke dashboard dengan pesan sukses
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