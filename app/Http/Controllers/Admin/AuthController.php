<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konsumen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.dashboard');
    }
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Email atau password salah');
    }

    public function showRegisterForm()
    {
        return view('admin.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:konsumens',
            'password' => 'required|confirmed',
        ]);

        User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => bcrypt($request->password),
        ]);

        return redirect()->route('admin.login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.dashboard');
    }
}
