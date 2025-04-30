<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($role === 'staff') {
                return redirect()->route('staff.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        }

        return back()->withErrors(['loginError' => 'Email atau Password salah']);
    }

    // Menampilkan halaman register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'whatsapp' => 'required|string|max:20',
            'asal' => 'required|string|max:255',
        ]);
    
        // Normalisasi nomor WhatsApp ke format 0815xxxx
        $rawWhatsapp = preg_replace('/[^0-9]/', '', $request->whatsapp); // hapus karakter non-angka
    
        if (str_starts_with($rawWhatsapp, '62')) {
            $normalizedWhatsapp = '0' . substr($rawWhatsapp, 2);
        } elseif (str_starts_with($rawWhatsapp, '8')) {
            $normalizedWhatsapp = '0' . $rawWhatsapp;
        } elseif (str_starts_with($rawWhatsapp, '0')) {
            $normalizedWhatsapp = $rawWhatsapp;
        } else {
            // fallback jika input tidak dikenali
            $normalizedWhatsapp = $rawWhatsapp;
        }
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'whatsapp' => $normalizedWhatsapp,
            'asal' => $request->asal,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        Auth::login($user);
    
        return redirect()->route('user.dashboard');
    }    

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
