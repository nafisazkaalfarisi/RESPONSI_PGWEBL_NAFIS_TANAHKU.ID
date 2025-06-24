<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses autentikasi login.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(); // Validasi login (email & password)

        $request->session()->regenerate(); // Hindari session fixation attack

        return redirect()->route('home'); // Redirect ke /home
    }

    /**
     * Logout dan akhiri sesi.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout(); // Logout

        $request->session()->invalidate();     // Hapus sesi
        $request->session()->regenerateToken(); // Buat token baru

        return redirect('/'); // Kembali ke landing page
    }
}
