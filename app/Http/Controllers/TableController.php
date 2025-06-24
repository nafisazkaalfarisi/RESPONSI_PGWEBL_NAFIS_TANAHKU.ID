<?php

namespace App\Http\Controllers;

use App\Models\PointsModel;
use App\Models\PolygonsModel;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Tabel Data Tanah',
            'points' => PointsModel::latest()->get(),
            'polygons' => PolygonsModel::latest()->get(),
        ];

        return view('table', $data);
    }
}
