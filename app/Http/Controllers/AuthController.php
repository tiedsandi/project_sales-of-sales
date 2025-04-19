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
            Alert::success('Welcome Back', 'You have successfully logged in!');
            return redirect('dashboard');
        } else {
            Alert::toast('Incorrect email or password!', 'error');
            return back()->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        Alert::toast('You have successfully logged out!', 'success');
        return redirect()->to('/');
    }
}
