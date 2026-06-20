<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('dosen')->attempt($credentials)) {
            return redirect()->route('dosen.dashboard');
        }

        if (Auth::guard('mahasiswa')->attempt($credentials)) {
            return redirect()->route('mahasiswa.dashboard');
        }

        return back()->withErrors(['username' => 'Username atau password salah']);
    }

    public function logout(Request $request)
    {
        if (Auth::guard('dosen')->check()) {
            Auth::guard('dosen')->logout();
        } elseif (Auth::guard('mahasiswa')->check()) {
            Auth::guard('mahasiswa')->logout();
        }
        return redirect('/login');
    }
}