<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Tampilkan halaman bantuan.
     */
    public function index()
    {
        return view('help', [
            'title' => 'Bantuan'
        ]);
    }
}
