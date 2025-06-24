<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Optional: auth route if using Sanctum
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API route untuk mengambil semua data point
Route::get('/points', [ApiController::class, 'points'])->name('api.points');

// API route untuk mengambil satu data point berdasarkan ID
Route::get('/point/{id}', [ApiController::class, 'point'])->name('api.point');

// API route untuk mengambil semua data polyline
Route::get('/polylines', [ApiController::class, 'polylines'])->name('api.polylines');

// API route untuk mengambil satu data polyline berdasarkan ID
Route::get('/polyline/{id}', [ApiController::class, 'polyline'])->name('api.polyline');

// API route untuk mengambil semua data polygon
Route::get('/polygons', [ApiController::class, 'polygons'])->name('api.polygons');

// API route untuk mengambil satu data polygon berdasarkan ID
Route::get('/polygon/{id}', [ApiController::class, 'polygon'])->name('api.polygon');
