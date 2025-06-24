<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PolygonsModel;
use App\Models\PointsModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik umum
        $polygonCount = PolygonsModel::count();
        $pointCount   = PointsModel::count();
        $userCount    = User::count();

        // Data chart: Distribusi Tanah per Kecamatan
        $chartDataKecamatan = PolygonsModel::select('district as label', DB::raw('COUNT(*) as total'))
            ->groupBy('district')
            ->orderBy('total', 'desc')
            ->get();

        // Data chart: Distribusi Tanah per Kabupaten
        $chartDataKabupaten = PolygonsModel::select('regency as label', DB::raw('COUNT(*) as total'))
            ->groupBy('regency')
            ->orderBy('total', 'desc')
            ->get();

        // 5 data tanah terbaru
        $recentPolygons = PolygonsModel::latest()->take(5)->get();

        return view('dashboard.index', [
            'polygonCount'       => $polygonCount,
            'pointCount'         => $pointCount,
            'userCount'          => $userCount,
            'chartDataKecamatan' => $chartDataKecamatan,
            'chartDataKabupaten' => $chartDataKabupaten,
            'recentPolygons'     => $recentPolygons,
        ]);
    }
}
