<?php

namespace App\Http\Controllers\Konsumen;

use App\Http\Controllers\Controller;
use App\Models\Konsumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.konsumen.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('konsumen')->attempt($credentials)) {
            return redirect()->route('konsumen.dashboard');
        }

        return back()->with('error', 'Email atau password salah');
    }

    public function showRegisterForm()
    {
        return view('admin.konsumen.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string',
            'email'    => 'required|email|unique:konsumens',
            'password' => 'required|confirmed',
            'alamat'   => 'nullable|string',
            'telepon'  => 'nullable|string',
        ]);

        Konsumen::create([
            'nama'         => $request->nama,
            'email'        => $request->email,
            'password'     => bcrypt($request->password),
            'alamat'       => $request->alamat,
            'telepon'      => $request->telepon,
        ]);

        return redirect()->route('konsumen.login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function logout()
    {
        Auth::guard('konsumen')->logout();
        return redirect()->route('konsumen.dashboard');
    }
}
