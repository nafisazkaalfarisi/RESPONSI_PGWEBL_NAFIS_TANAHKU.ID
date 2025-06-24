<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PolygonsModel;
use App\Models\PointsModel;

class LandingController extends Controller
{
    /**
     * Menampilkan halaman landing berisi daftar tanah & titik lokasi.
     */
    public function index(Request $request)
{
    // Redirect jika sudah login
    if (auth()->check()) {
        return redirect()->route('home');
    }

    $search = $request->input('q');

    // Ambil data polygon
    $polygons = PolygonsModel::query()
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        })
        ->latest()
        ->take(6)
        ->get();

    // Ambil data titik (points)
    $points = PointsModel::query()
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        })
        ->latest()
        ->take(6)
        ->get();

    return view('landing.index', [
        'title' => 'Beranda',
        'polygons' => $polygons,
        'points' => $points,
    ]);
}

}
