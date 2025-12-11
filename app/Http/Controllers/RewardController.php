<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\Driver;
use App\Events\DriverPointsUpdated;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DriversPointExport;

class RewardController extends Controller
{
    public function index()
    {
        
        // 1. Ambil SEMUA data reward dengan eager load 'driver', diurutkan berdasarkan tanggal terbaru
        // Catatan: Karena kita akan mengelompokkan data di memori, kita mengambil semua data terkait.
        // Jika data reward sangat besar, pertimbangkan untuk menggunakan DB::raw atau query builder.
        $rawRewards = Reward::with('driver')->orderByDesc('created_at')->get();

        // 2. Kelompokkan data berdasarkan driver_id
        $groupedRewards = $rawRewards->groupBy('driver_id');

        // 3. Olah setiap grup untuk mendapatkan satu baris ringkasan per driver
        $rewardsByDriver = $groupedRewards->map(function ($driverRewards, $driverId) {
            // Ambil data pertama dari grup untuk informasi dasar driver
            $firstReward = $driverRewards->first(); 
            
            // Hitung total poin yang dihabiskan dan total reward yang dikonversi
            $totalPointsSpent = $driverRewards->sum('points_spent'); 
            $totalConvertPoint = $driverRewards->sum('convert_point');

            // Ambil data reward terbaru untuk menentukan status dan tanggal terakhir
            $latestReward = $driverRewards->sortByDesc('created_at')->first();

            return (object) [
                'id' => $driverId,
                'driver_name' => $firstReward->driver->name ?? '-',
                'driver_id_card' => $firstReward->driver->driver_id_card ?? null,
                'total_reward' => $totalConvertPoint, // Total reward dalam mata uang
                'total_points_spent' => $totalPointsSpent, // Total poin yang dihabiskan
                'latest_status' => $latestReward->status, // Status reward terbaru
                'latest_date' => $latestReward->created_at, // Tanggal transaksi reward terbaru
                'original_driver' => $firstReward->driver, // Objek Driver untuk keperluan export
                // Kirim koleksi reward asli jika diperlukan di Blade (misalnya untuk modal detail)
                'driver_rewards' => $driverRewards, 
            ];
        })
        // Konversi collection hasil map menjadi objek LengthAwarePaginator untuk mempertahankan fungsi paginate/links
        // Namun, karena kita melakukan grouping, pagination normal akan menjadi sulit.
        // Untuk kemudahan, kita kirim Collection biasa dan hilangkan pagination sementara.
        // Jika pagination wajib, kita perlu menggunakan Paginator::make atau melakukan pagination manual.
        ->values();

        // Ambil daftar driver untuk form Export
        $drivers = Driver::orderBy('name')->get();
        
        // Catatan: Statistik lama (totalRewards, totalPointsUsed, dll) dihilangkan
        // karena tidak digunakan dalam compact, Anda bisa menambahkannya kembali jika diperlukan.

        return view('dashboard.reward', [
            'rewards' => $rewardsByDriver, // Menggunakan data yang sudah di-group
            'drivers' => $drivers,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            // Pastikan Anda menangani validasi decimal dengan benar tergantung pada versi PHP/Laravel Anda
            'convert_point' => 'required|numeric|min:0', 
            'points_spent' => 'required|integer|min:1',
            'status' => 'required|in:pending,completed,rejected',
        ]);

        Reward::create($validated);

        return redirect()->route('reward.index')->with('success', 'Reward berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $reward = Reward::findOrFail($id);
        $reward->delete();

        return redirect()->route('reward.index')->with('success', 'Reward berhasil dihapus!');
    }

    /**
     * Menangani penukaran poin menjadi uang tunai
     */
    public function tukarPoin(Request $request)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'points' => 'required|integer|min:1'
        ]);

        $driver = Driver::findOrFail($request->driver_id);
        
        // Hitung total poin yang sudah ditukar dari kolom points_redeemed
        $totalPointsSpent = $driver->points_redeemed ?? 0;
        $remainingPoints = $driver->total_points - $totalPointsSpent;
        
        // Validasi saldo poin cukup
        if ($remainingPoints < $request->points) {
            return back()->with('error', 'Saldo poin tidak mencukupi. Sisa poin yang dapat ditukar: ' . $remainingPoints);
        }
        
        // Hitung nilai tukar (1 poin = Rp 50.000)
        $convertPoint = $request->points * 50000;
        
        try {
            // Buat catatan penukaran poin
            $reward = Reward::create([
                'driver_id' => $driver->id,
                'points_spent' => $request->points,
                'convert_point' => $convertPoint,
                'status' => 'completed',
                'remaining_points' => $remainingPoints - $request->points
            ]);

            // Update total poin yang sudah ditukarkan di tabel drivers
            $driver->increment('points_redeemed', $request->points);

            // Hitung ulang berdasarkan kolom points_redeemed yang sudah diperbarui
            $driver->refresh();
            $totalPointsSpentUpdated = $driver->points_redeemed ?? 0;
            $remainingPointsUpdated = $driver->total_points - $totalPointsSpentUpdated;

            // Broadcast perubahan poin driver secara realtime
            broadcast(new DriverPointsUpdated($driver->id, $driver->total_points, $remainingPointsUpdated));
            
            return redirect()
                ->route('driver.index')
                ->with([
                    'success' => 'Poin berhasil ditukarkan senilai Rp ' . number_format($convertPoint, 0, ',', '.'),
                    'refreshed' => true
                ]);
                
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Metode export tetap sama
    public function export(Request $request)
    {
        $driverId = $request->query('driver_id');
        
        if (!$driverId) {
            return redirect()->route('reward.index')->with('error', 'Silakan pilih driver terlebih dahulu');
        }
        // Try to find driver to build a friendly filename
        $driver = Driver::find($driverId);
        if ($driver) {
            $rawName = $driver->name ?? ('driver_'.$driverId);
            // transliterate Unicode names to ASCII when possible
            if (function_exists('iconv')) {
                $trans = @iconv('UTF-8', 'ASCII//TRANSLIT', $rawName);
                if ($trans !== false && strlen(trim($trans)) > 0) {
                    $rawName = $trans;
                }
            }
            // sanitize: keep alphanumerics, dash and underscore; replace others with underscore
            $safe = preg_replace('/[^A-Za-z0-9\-]+/', '_', $rawName);
            $safe = preg_replace('/_+/', '_', $safe);
            $safe = trim($safe, '_');
            $safe = strtolower($safe);
            if (empty($safe)) {
                $safe = 'driver_'.$driverId;
            }
            $filename = $safe . '_points_' . $driverId . '.xlsx';
        } else {
            $filename = 'driver_' . $driverId . '_points.xlsx';
        }

        return Excel::download(new DriversPointExport([$driverId]), $filename);
    }

    // Metode export untuk semua driver yang ada di tabel reward
    public function exportAll()
    {
        // Ambil data reward yang sudah di-group (sama seperti di index method)
        $rawRewards = Reward::with('driver')->orderByDesc('created_at')->get();
        $groupedRewards = $rawRewards->groupBy('driver_id');
        
        // Kelompokkan data berdasarkan driver_id dan ambil driver yang punya reward
        $rewardsByDriver = $groupedRewards->map(function ($driverRewards, $driverId) {
            $firstReward = $driverRewards->first(); 
            return (object) [
                'id' => $driverId,
                'driver_name' => $firstReward->driver->name ?? '-',
                'driver_id_card' => $firstReward->driver->driver_id_card ?? null,
                'total_reward' => $driverRewards->sum('convert_point'),
                'total_points_spent' => $driverRewards->sum('points_spent'),
                'latest_status' => $driverRewards->sortByDesc('created_at')->first()->status,
                'latest_date' => $driverRewards->sortByDesc('created_at')->first()->created_at,
                'original_driver' => $firstReward->driver,
            ];
        })->values();

        // Ambil hanya driver ID yang ada di reward
        $driverIds = $rewardsByDriver->pluck('id')->toArray();
        
        // Buat instance export class dengan driver IDs yang difilter
        $export = new DriversPointExport($driverIds);
        
        // Override collection method untuk menggunakan format sederhana
        $export->setCollection(Driver::whereIn('id', $driverIds)
                                ->select('driver_id_card', 'name', 'instansi', 'total_points', 'created_at')
                                ->get());
        
        $filename = 'reward_drivers_points_' . date('Y-m-d') . '.xlsx';
        return Excel::download($export, $filename);
    }
}