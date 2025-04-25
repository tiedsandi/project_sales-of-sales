<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;


class AuthController extends Controller
{
    public function login()
    {
        // get Role dropdown from database role is active
        $roles = Role::where('is_active', 1)->get();
        return view('login', compact('roles'));
    }

    public function actionLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|exists:roles,id'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $selectedRoleId = $request->input('role');
            if (!$user->roles->contains('id', $selectedRoleId)) {
                Auth::logout();
                Alert::toast('Role invalid!', 'error');
                return back()->withInput();
            }
            session(['selected_role' => $user->roles->firstWhere('id', $selectedRoleId)->name]);

            Alert::success('Welcome Back', 'You have successfully logged in!');
            // return redirect('dashboard');

            $selectedRole = session('selected_role');

            if ($selectedRole == 'Administrator' || $selectedRole == 'Pimpinan') {
                return redirect('dashboard');
            } elseif ($selectedRole == 'Kasir') {
                return redirect('pos-sale');
            }
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
