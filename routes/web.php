<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public Routes (No Auth Required)
// Halaman utama: redirect root ke halaman scan driver (public)
Route::get('/', function () {
    return redirect()->route('scan.landing');
});

// Halaman landing scan / cari ID driver (tanpa login)
Route::get('/scan-page', function () {
    return view('scan.landing');
})->name('scan.landing');

// Halaman error driver tidak ditemukan
Route::get('/driver-not-found', function () {
    return view('scan.driver-not-found');
})->name('driver.not.found');

// Driver Point - View points only (QR Code 2D)
Route::get('/driver/point/{driverIdCard}', [App\Http\Controllers\DriverPointController::class, 'showPoints'])->name('driver.point');
// Driver Scan - Record transaction when bringing patient (Barcode 1D)
Route::get('/driver/scan/{driverIdCard}', [App\Http\Controllers\DriverPointController::class, 'scanTransaction'])->name('driver.scan')  ->where('driverIdCard', '.*');  // Menerima nilai kosong;
// Driver Scan - Store patient data (public, tanpa auth)
Route::post('/driver/scan/{transaction}/patient', [App\Http\Controllers\DriverPointController::class, 'storePatientData'])->name('driver.scan.patient');

// Auth Routes (login admin dipindah ke /admin)
Route::get('/admin', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/admin', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/scan-count', [\App\Http\Controllers\DashboardController::class, 'scanCount'])->name('dashboard.scan-count');
    Route::get('/dashboard/patient-count', [\App\Http\Controllers\DashboardController::class, 'patientCount'])->name('dashboard.patient-count');
    Route::get('/dashboard/points-count', [\App\Http\Controllers\DashboardController::class, 'pointsCount'])->name('dashboard.points-count');
    Route::post('/dashboard/reset-points', [\App\Http\Controllers\DashboardController::class, 'resetAllPoints'])->name('dashboard.reset-points');
    Route::get('/dashboard/patient-chart-data', [\App\Http\Controllers\DashboardController::class, 'patientChartData'])->name('dashboard.patient-chart-data');
    Route::get('/dashboard/monthly-patient-data', [\App\Http\Controllers\DashboardController::class, 'monthlyPatientData'])->name('dashboard.monthly-patient-data');
    Route::get('/dashboard/patient-destination-data', [\App\Http\Controllers\DashboardController::class, 'patientDestinationData'])->name('dashboard.patient-destination-data');
    
    // Driver Routes
    Route::get('/driver/qrcode/all', [App\Http\Controllers\DriverController::class, 'qrcodeAll'])->name('driver.qrcode.all');
    Route::get('/driver/{driver}/qrcode', [App\Http\Controllers\DriverController::class, 'qrcodeSingle'])->name('driver.qrcode.single');
    Route::resource('driver', App\Http\Controllers\DriverController::class);
    
    // Scan Routes
    Route::prefix('scan')->name('scan.')->group(function () {
        Route::get('/', [App\Http\Controllers\ScanController::class, 'index'])->name('index');
        Route::get('/pending-count', [App\Http\Controllers\ScanController::class, 'getPendingCount'])->name('pending-count');
        Route::get('/confirm/{id}', [App\Http\Controllers\ScanController::class, 'confirm'])->name('confirm');
        Route::post('/confirm/{id}', [App\Http\Controllers\ScanController::class, 'processConfirm'])->name('process');
        Route::post('/reject/{id}', [App\Http\Controllers\ScanController::class, 'reject'])->name('reject');
    });
    
    // Pasien Routes
    Route::prefix('pasien')->name('pasien.')->group(function () {
        Route::get('/', [App\Http\Controllers\PatientController::class, 'index'])->name('index');
    });
    
    // Patient Routes (alternative naming)
    Route::prefix('patient')->name('patient.')->group(function () {
        Route::get('/', [App\Http\Controllers\PatientController::class, 'index'])->name('index');
        Route::get('/{id}', [App\Http\Controllers\PatientController::class, 'show'])->name('show');
    });
    
    // Reward Routes
    Route::prefix('reward')->name('reward.')->group(function () {
        Route::get('/', [App\Http\Controllers\RewardController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\RewardController::class, 'store'])->name('store');
        Route::delete('/{reward}', [App\Http\Controllers\RewardController::class, 'destroy'])->name('destroy');
        Route::get('/export', [App\Http\Controllers\RewardController::class, 'export'])->name('export');
        Route::get('/export-all', [App\Http\Controllers\RewardController::class, 'exportAll'])->name('export-all');
        Route::post('/tukar-poin', [App\Http\Controllers\RewardController::class, 'tukarPoin'])->name('tukar-poin');
    });
    
    // Point & Reward
    Route::get('/dashboard/point-reward', [\App\Http\Controllers\PointRewardController::class, 'index'])->name('dashboard.point');
    Route::get('/dashboard/point-reward/export', [\App\Http\Controllers\PointRewardController::class, 'export'])->name('dashboard.point.export');
});