<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PolygonsModel;
use App\Models\PointsModel;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');

        $polygons = PolygonsModel::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('district', 'like', "%{$search}%")
                      ->orWhere('regency', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->take(6)
            ->get();

        $points = PointsModel::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('village', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->take(6)
            ->get();

        return view('home', [
            'title' => 'Beranda',
            'search' => $search,
            'polygons' => $polygons,
            'points' => $points,
        ]);
    }
}
