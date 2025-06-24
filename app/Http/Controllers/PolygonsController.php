<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PolygonsModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Notifications\PolygonAdded;

class PolygonsController extends Controller
{
    protected $polygons;

    public function __construct()
    {
        $this->polygons = new PolygonsModel();
    }

    public function api()
    {
        $polygons = DB::table('polygons')
    ->leftJoin('users', 'polygons.user_id', '=', 'users.id')
    ->select(
        'polygons.id',
        'polygons.name',
        'polygons.description',
        'polygons.certificate',
        'polygons.land_use',
        'polygons.road_access',
        'polygons.regency',
        'polygons.district',
        'polygons.image',
        DB::raw('ST_AsGeoJSON(polygons.geom) as geometry'),
        DB::raw('ST_Area(polygons.geom, true) / 10000 as area_hektar'),
        'users.name as user_name'
    )
    ->get();


        $features = [];

        foreach ($polygons as $polygon) {
            $features[] = [
                'type' => 'Feature',
                'geometry' => json_decode($polygon->geometry),
                'properties' => [
                    'id' => $polygon->id,
                    'name' => $polygon->name,
                    'certificate' => $polygon->certificate,
                    'land_use' => $polygon->land_use,
                    'road_access' => $polygon->road_access,
                    'regency' => $polygon->regency,
    'district' => $polygon->district,
                    'image' => $polygon->image,
                    'image_url' => $polygon->image ? asset('storage/images/' . $polygon->image) : null,
                    'area_hektar' => round($polygon->area_hektar, 2),
                    'user_name' => $polygon->user_name,
                ]
            ];
        }

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $features
        ]);
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:polygons,name',
        'description' => 'required',
        'certificate' => 'required',
        'land_use' => 'required',
        'road_access' => 'required',
        'regency' => 'required',
    'district' => 'required',
        'geom_polygon' => 'required',
        'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $name_image = $this->handleImageUpload($request->file('image'));

    $data = [
        'geom' => DB::raw("ST_GeomFromText('" . $request->geom_polygon . "', 4326)"),
        'name' => $request->name,
        'description' => $request->description,
        'certificate' => $request->certificate,
        'land_use' => $request->land_use,
        'road_access' => $request->road_access,
        'regency' => $request->regency,
    'district' => $request->district,
        'image' => $name_image,
        'user_id' => auth()->id(),
    ];

    $created = $this->polygons->create($data);

    if (!$created) {
        return redirect()->route('map')->with('error', 'Polygon failed to add');
    }

    // Kirim notifikasi ke semua user
$users = User::all();
foreach ($users as $user) {
    $user->notify(new PolygonAdded($created));
}

    return redirect()->route('map', ['focus_polygon' => $created->id])
        ->with('success', 'Polygon tanah berhasil ditambahkan');
}


    public function index(Request $request)
{
    $focusPointId = $request->query('focus_point');
    $focusPolygonId = $request->query('focus_polygon');

    return view('map', [
        'title' => 'Map',
        'focus_point_id' => $focusPointId,
        'focus_polygon_id' => $focusPolygonId,
    ]);
}


    public function show($id)
    {
        $polygon = DB::table('polygons')
            ->select('id', 'name', 'description', 'image', DB::raw("ST_AsGeoJSON(geom) as geojson"))
            ->where('id', $id)
            ->first();

        return view('polygons.show', compact('polygon'));
    }

    public function edit(string $id)
    {
        return view('edit-polygon', [
            'title' => 'Edit Polygon',
            'id' => $id,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:polygons,name,' . $id,
            'description' => 'required',
            'certificate' => 'required',
            'land_use' => 'required',
            'road_access' => 'required',
            'regency' => 'required',
    'district' => 'required',
            'geom_polygon' => 'required',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:10000',
        ]);

        $polygon = $this->polygons->findOrFail($id);
        $old_image = $polygon->image;

        $name_image = $this->handleImageUpload($request->file('image'), $old_image);

        $data = [
            'geom' => DB::raw("ST_GeomFromText('" . $request->geom_polygon . "', 4326)"),
            'name' => $request->name,
            'description' => $request->description,
            'certificate' => $request->certificate,
            'land_use' => $request->land_use,
            'road_access' => $request->road_access,
            'regency' => $request->regency,
    'district' => $request->district,
            'image' => $name_image,
        ];

        $updated = DB::table('polygons')->where('id', $id)->update($data);

        if (!$updated) {
            return redirect()->route('map')->with('error', 'Polygon failed to update');
        }

        return redirect()->route('map', ['focus_polygon' => $id])
    ->with('success', 'Polygon tanah berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $polygon = $this->polygons->findOrFail($id);
        $imagefile = $polygon->image;

        if (!$polygon->delete()) {
            return redirect()->route('map')->with('error', 'Polygon failed to delete');
        }

        if ($imagefile && File::exists(public_path('storage/images/' . $imagefile))) {
            unlink(public_path('storage/images/' . $imagefile));
        }

        return redirect()->route('map')->with('success', 'Polygon has been deleted');
    }

    /**
     * Handle image upload and delete old image if provided.
     */
    private function handleImageUpload($image, $oldImage = null)
    {
        if ($image) {
            if (!Storage::disk('public')->exists('images')) {
                Storage::disk('public')->makeDirectory('images');
            }

            $filename = time() . "_polygon." . strtolower($image->getClientOriginalExtension());
            $image->storeAs('images', $filename, 'public');

            if ($oldImage && File::exists(public_path('storage/images/' . $oldImage))) {
                unlink(public_path('storage/images/' . $oldImage));
            }

            return $filename;
        }

        return $oldImage;
    }
}
