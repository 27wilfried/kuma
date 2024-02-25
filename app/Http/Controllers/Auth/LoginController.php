<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importation de la façade Auth
use Illuminate\Support\Facades\Hash; // Importation de la façade Hash

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.product.index');
        }

        return back()->withErrors(['email' => 'Email or password incorrect']);
    }
}
