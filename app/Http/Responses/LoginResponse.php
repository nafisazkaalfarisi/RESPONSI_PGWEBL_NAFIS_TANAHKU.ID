<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        // Arahkan user ke halaman tertentu setelah login
        return redirect()->intended('/home'); // ← Ubah ke halaman yang kamu mau, misal '/dashboard' atau '/map'
    }
}
