<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function showLogin(Request $request): View
    {
        return view('auth.admin-login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt(
            array_merge($credentials, ['is_admin' => true]),
            $request->boolean('remember')
        )) {
            return back()
                ->withErrors(['email' => 'Ces identifiants ne correspondent pas à un administrateur.'])
                ->withInput(['email' => $credentials['email']]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.posts.create'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
