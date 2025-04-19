<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;


class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function actionLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            Alert::success('Selamat Datang', 'Anda berhasil login kembali!');
            return redirect('dashboard');
        } else {
            Alert::toast('Email dan password salah!', 'error');
            return back()->withErrors(['error' => 'Login Gagal, Silahkan Coba Lagi'])->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        Alert::toast('Anda berhasil logout!', 'success');
        return redirect()->to('/');
    }
}
