<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PointsModel extends Model
{
    protected $table = 'points';

    protected $fillable = [
        'name',
        'description',
        'geom',
        'image',
        'price',
        'status',
        'contact',
        'village',
        'user_id',
    ];

    /**
     * Mengembalikan semua point dalam format GeoJSON FeatureCollection
     */
    public function geojson_points()
    {
        $points = self::select(DB::raw('
            id,
            ST_AsGeoJSON(geom) as geom,
            name,
            description,
            image,
            price,
            status,
            contact,
            village,
            created_at
        '))->get();

        $features = [];

        foreach ($points as $point) {
            if (!isset($point->geom)) continue; // Cegah error jika geom null atau tidak tersedia

            $features[] = [
                'type' => 'Feature',
                'geometry' => json_decode($point->geom),
                'properties' => [
                    'id' => $point->id,
                    'name' => $point->name,
                    'description' => $point->description,
                    'price' => $point->price,
                    'status' => $point->status,
                    'contact' => $point->contact,
                    'village' => $point->village,
                    'created_at' => $point->created_at,
                    'image_url' => $point->image ? asset('storage/images/' . $point->image) : null,
                ],
            ];
        }

        return [
            'type' => 'FeatureCollection',
            'features' => $features,
        ];
    }

    /**
     * Mengembalikan satu titik dalam format GeoJSON berdasarkan ID
     */
    public function geojson_point($id)
    {
        $p = self::select(DB::raw('
            id,
            ST_AsGeoJSON(geom) as geom,
            name,
            description,
            image,
            price,
            status,
            contact,
            village,
            created_at,
            updated_at
        '))
        ->where('id', $id)
        ->first();

        if (!$p || !isset($p->geom)) {
            return [
                'type' => 'FeatureCollection',
                'features' => [],
                'message' => 'Point not found or missing geometry',
            ];
        }

        return [
            'type' => 'FeatureCollection',
            'features' => [[
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'image' => $p->image,
                    'price' => $p->price,
                    'status' => $p->status,
                    'contact' => $p->contact,
                    'village' => $p->village,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at,
                ],
            ]],
        ];
    }
}
