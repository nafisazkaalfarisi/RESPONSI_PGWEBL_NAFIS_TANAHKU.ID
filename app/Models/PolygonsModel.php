<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PolygonsModel extends Model
{
    protected $table = 'polygons';
    protected $guarded = ['id'];

    /**
     * Mengembalikan semua polygon dalam format GeoJSON FeatureCollection
     */
    public function geojson_polygons()
    {
        $polygons = $this->select(DB::raw('
                polygons.id,
                ST_AsGeoJSON(polygons.geom) AS geom,
                polygons.name,
                polygons.description,
                polygons.certificate,
                polygons.land_use,
                polygons.road_access,
                polygons.regency,
                polygons.district,
                polygons.image,
                polygons.created_at,
                polygons.updated_at,
                polygons.user_id,
                ST_Area(polygons.geom, true) AS area_m2,
                ST_Area(polygons.geom, true) / 1000000 AS area_km2,
                ST_Area(polygons.geom, true) / 10000 AS area_hektar,
                users.name AS user_created
            '))
            ->leftJoin('users', 'polygons.user_id', '=', 'users.id')
            ->get();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        foreach ($polygons as $p) {
            if (!isset($p->geom)) continue;

            $geojson['features'][] = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'certificate' => $p->certificate,
                    'land_use' => $p->land_use,
                    'road_access' => $p->road_access,
                    'regency' => $p->regency,
                    'district' => $p->district,
                    'image' => $p->image,
                    'image_url' => $p->image ? asset('storage/images/' . $p->image) : null,
                    'area_m2' => $p->area_m2,
                    'area_km2' => $p->area_km2,
                    'area_hektar' => $p->area_hektar,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at,
                    'user_id' => $p->user_id,
                    'user_created' => $p->user_created,
                ],
            ];
        }

        return $geojson;
    }

    /**
     * Mengembalikan satu polygon dalam format GeoJSON berdasarkan ID
     */
    public function geojson_polygon($id)
    {
        $polygon = $this->select(DB::raw('
                id,
                ST_AsGeoJSON(geom) AS geom,
                name,
                description,
                certificate,
                land_use,
                road_access,
                regency,
                district,
                image,
                ST_Area(geom, true) AS area_m2,
                ST_Area(geom, true) / 1000000 AS area_km2,
                ST_Area(geom, true) / 10000 AS area_hektar,
                created_at,
                updated_at
            '))
            ->where('id', $id)
            ->first();

        if (!$polygon || !isset($polygon->geom)) {
            return [
                'type' => 'FeatureCollection',
                'features' => [],
                'message' => 'Polygon not found or missing geometry',
            ];
        }

        return [
            'type' => 'FeatureCollection',
            'features' => [[
                'type' => 'Feature',
                'geometry' => json_decode($polygon->geom),
                'properties' => [
                    'id' => $polygon->id,
                    'name' => $polygon->name,
                    'description' => $polygon->description,
                    'certificate' => $polygon->certificate,
                    'land_use' => $polygon->land_use,
                    'road_access' => $polygon->road_access,
                    'regency' => $polygon->regency,
                    'district' => $polygon->district,
                    'image' => $polygon->image,
                    'image_url' => $polygon->image ? asset('storage/images/' . $polygon->image) : null,
                    'area_m2' => $polygon->area_m2,
                    'area_km2' => $polygon->area_km2,
                    'area_hektar' => $polygon->area_hektar,
                    'created_at' => $polygon->created_at,
                    'updated_at' => $polygon->updated_at,
                ],
            ]],
        ];
    }
}
