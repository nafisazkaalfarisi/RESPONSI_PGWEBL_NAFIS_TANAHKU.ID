<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PointsModel;
use Illuminate\Support\Facades\Storage;

class PointsController extends Controller
{
    protected $points;

    public function __construct()
    {
        $this->points = new PointsModel();
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


    public function api()
    {
        $geojson = $this->points->geojson_points();
        return response()->json($geojson);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:points,name',
            'description' => 'required',
            'geom' => 'required',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,terjual',
            'contact' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = null;
if ($request->hasFile('image')) {
    $image = $request->file('image');
    $imageName = time() . '_point.' . $image->getClientOriginalExtension();

    // Cek dan buat folder images jika belum ada
    if (!Storage::disk('public')->exists('images')) {
        Storage::disk('public')->makeDirectory('images');
    }

    // Simpan gambar ke storage/app/public/images
    Storage::disk('public')->putFileAs('images', $image, $imageName);
}


        $created = $this->points->create([
            'name' => $request->name,
            'description' => $request->description,
            'geom' => $request->geom,
            'image' => $imageName,
            'price' => $request->price,
            'status' => $request->status,
            'contact' => $request->contact,
            'village' => $request->village,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('map', ['focus_point' => $created->id])
    ->with('success', 'Titik tanah berhasil ditambahkan');

    }

     public function edit(string $id)
{
    $point = $this->points->findOrFail($id);

    // Ambil koordinat dari kolom geom (format GeoJSON)
    $geojson = \DB::table('points')
        ->selectRaw("ST_AsGeoJSON(geom) as geom")
        ->where('id', $id)
        ->first();

    $coords = json_decode($geojson->geom)->coordinates;
    $lat = $coords[1];
    $lng = $coords[0];

    return view('edit-point', [
        'title' => 'Edit Titik Tanah',
        'point' => $point,
        'lat' => $lat,
        'lng' => $lng
    ]);
}

public function update(Request $request, string $id)
{
    $request->validate([
        'name' => 'required|unique:points,name,' . $id,
        'description' => 'required',
        'geom' => 'required',
        'price' => 'required|numeric|min:0',
        'status' => 'required|in:tersedia,terjual',
        'contact' => 'required|string|max:255',
        'village' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10000',
    ]);

    $point = $this->points->findOrFail($id);
    $imageName = $point->image;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_point.' . $image->getClientOriginalExtension();

        if (!Storage::disk('public')->exists('images')) {
            Storage::disk('public')->makeDirectory('images');
        }

        Storage::disk('public')->putFileAs('images', $image, $imageName);

        if ($point->image && Storage::disk('public')->exists('images/' . $point->image)) {
            Storage::disk('public')->delete('images/' . $point->image);
        }
    }

    $point->update([
        'name' => $request->name,
        'description' => $request->description,
        'geom' => $request->geom, // Disamakan dengan form tambah
        'image' => $imageName,
        'price' => $request->price,
        'status' => $request->status,
        'contact' => $request->contact,
        'village' => $request->village,
    ]);

    return redirect()->route('map', ['focus_point' => $id])
    ->with('success', 'Titik tanah berhasil diperbarui');

}


    public function destroy(string $id)
    {
        $point = $this->points->findOrFail($id);

        if ($point->image && Storage::disk('public')->exists('images/' . $point->image)) {
            Storage::disk('public')->delete('images/' . $point->image);
        }

        $point->delete();

        return redirect()->route('map')->with('success', 'Titik tanah berhasil dihapus');
    }
}
