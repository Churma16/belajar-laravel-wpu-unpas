<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view("login.index", [
            'title' => 'Login',
            'active' => 'login',
        ]);
    }

    public function authenticate(Request $request)
    {
        //mengecek credentials belum valid atau invalid
        $credentials = $request->validate([
            // 'email' => 'required|email:dns',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //sudah mengecek tabel user
        if (Auth::attempt($credentials)) {
            //refresh session
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        //else
        return back()->with('loginError', 'Login failed!');

        dd('Berhasil Login');
    }

    public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

// NOTE PENTING :
// Mungkin, bagi temen-temen yang bingung saat proses autentikasi, dan bertanya "Kok laravel nya tau kita menggunakan tabel users? Kalau seandainya nama tabel kita bukan users gimana? Kalau seandainya ingin menggunakan tabel lain atau nama tabelnya beda gimana?".

// Kalian bisa buka folder config, trus pilih file auth.php
// Disitu defaultnya adalah 'model' => App\Models\User::class
// Kalian bisa ganti itu sesuai yang kalian mau, mau retrieving (mengambil) users nya menggunakan model / tabel apa.

// "Kalau aku ada multiple user tables atau models gimana?".
// tinggal kalian tambah aja source nya di file auth.php tadi.

// tambahan : inget ya, pak Sandhika Galih udh ngmng kalo "satu model itu merepresentasikan satu tabel".