<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('home'); // Redireciona após o login
        }

        return back()->withErrors(['email' => 'Credenciais inválidas']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
