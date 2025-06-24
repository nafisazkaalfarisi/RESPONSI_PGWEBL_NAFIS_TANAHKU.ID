<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PointsModel;
use App\Models\PolygonsModel;

class ApiController extends Controller
{
    protected $points;
    protected $polylines;
    protected $polygons;

    public function __construct()
    {
        $this->points = new PointsModel();
        $this->polygons = new PolygonsModel();
    }

    // API untuk semua point
    public function points()
    {
        $points = $this->points->geojson_points();
        return response()->json($points);
    }

    // API untuk satu point berdasarkan ID
    public function point($id)
    {
        $point = $this->points->geojson_point($id);
        return response()->json($point);
    }


    // API untuk semua polygon
    public function polygons()
    {
        $polygons = $this->polygons->geojson_polygons();
        return response()->json($polygons);
    }

    // API untuk satu polygon berdasarkan ID
    public function polygon($id)
    {
        $polygon = $this->polygons->geojson_polygon($id);
        return response()->json($polygon);
    }
}
