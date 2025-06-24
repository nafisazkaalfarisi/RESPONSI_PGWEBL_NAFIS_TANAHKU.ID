<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings', [
            'theme' => session('theme', 'light')
        ]);
    }

    public function toggleTheme(Request $request)
    {
        $currentTheme = session('theme', 'light');
        $newTheme = $currentTheme === 'light' ? 'dark' : 'light';
        session(['theme' => $newTheme]);

        return back();
    }
}
