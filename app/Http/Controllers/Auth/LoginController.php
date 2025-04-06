<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Aquí implementaremos la lógica de autenticación con Firebase
        // Por ahora, crearemos un usuario de prueba
        $user = User::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => 'Usuario de Prueba',
                'password' => bcrypt('password')
            ]
        );

        Auth::login($user);

        return redirect()->intended(route('home'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
} 