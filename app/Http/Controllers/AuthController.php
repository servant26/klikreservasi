<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Method helper untuk redirect berdasarkan role
    protected function redirectToDashboard()
    {
        $role = Auth::user()->role;
        
        return match($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'staff' => redirect()->route('staff.dashboard'),
            default => redirect()->route('user.dashboard')
        };
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
        ], [
            'email.unique' => 'Email telah terdaftar',
        ]);

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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'whatsapp' => $normalizedWhatsapp,
            'asal' => $request->asal,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        Auth::login($user);
        return $this->redirectToDashboard();
    }

    // Menampilkan halaman login
    public function showLogin(Request $request)
    {
        // generate captcha random 4 karakter
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $captcha = substr(str_shuffle($characters), 0, 4);

        // simpan ke session
        $request->session()->put('captcha_code', $captcha);

        return view('auth.login', compact('captcha'));
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
            'captcha' => 'required|size:4'
        ]);

        // cek captcha (case sensitive)
        if ($request->captcha !== session('captcha_code')) {
            return back()->withErrors(['captcha' => 'Kode captcha salah'])->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // hapus captcha biar tidak reuse
            $request->session()->forget('captcha_code');
            return $this->redirectToDashboard();
        }

        return back()->withErrors(['loginError' => 'Email atau Password salah'])->withInput();
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home'); // Kembali ke homepage setelah logout
    }
}