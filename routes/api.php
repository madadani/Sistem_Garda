<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Endpoint untuk memeriksa ID Card/No HP
Route::get('/check-driver/{driverId}', function($driverId) {
    // Validasi input (10-16 digit angka)
    if (!preg_match('/^\d{10,16}$/', $driverId)) {
        return response()->json([
            'success' => false,
            'message' => 'Format ID/No HP tidak valid. Harus 10-16 digit angka.'
        ], 400);
    }

    try {
        $exists = \App\Models\Driver::where('driver_id_card', $driverId)->exists();
        
        return response()->json([
            'success' => true,
            'exists' => $exists,
            'message' => $exists ? 'Driver ditemukan' : 'Driver tidak ditemukan'
        ]);
    } catch (\Exception $e) {
        \Log::error('Error checking driver ID: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan server. Silakan coba lagi nanti.'
        ], 500);
    }
})->where('driverId', '[0-9]+');
