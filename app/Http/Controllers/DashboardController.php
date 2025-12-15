<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Patient;
use App\Models\Transaction;
use App\Models\Reward;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung statistik utama
        $totalDrivers = Driver::count();
        $totalPatients = Patient::count();
        $totalPoints = Driver::sum('total_points');
        
        // Hitung untuk hari ini dengan logic yang sama dengan ScanController
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        
        $scansToday = Transaction::whereDate('scan_time', $today)
            ->where('status', 'CONFIRMED')
            ->whereHas('patient', function($q) {
                $q->whereNotNull('patient_name')
                  ->where('patient_name', '!=', '')
                  ->whereNotNull('patient_condition')
                  ->where('patient_condition', '!=', '');
            })->count();
            
        $scansYesterday = Transaction::whereDate('scan_time', $yesterday)
            ->where('status', 'CONFIRMED')
            ->whereHas('patient', function($q) {
                $q->whereNotNull('patient_name')
                  ->where('patient_name', '!=', '')
                  ->whereNotNull('patient_condition')
                  ->where('patient_condition', '!=', '');
            })->count();
        
        $newDriversToday = Driver::whereDate('created_at', $today)->count();
        $newPatientsToday = Patient::whereDate('created_at', $today)->count();
        
        $totalPointsYesterday = Driver::whereDate('created_at', '<=', $yesterday)->sum('total_points');
        
        // Ambil aktivitas terbaru
        $recentActivities = $this->getRecentActivities();
        
        return view('dashboard.index', compact(
            'totalDrivers',
            'totalPatients',
            'totalPoints',
            'scansToday',
            'scansYesterday',
            'newDriversToday',
            'newPatientsToday',
            'totalPointsYesterday',
            'recentActivities'
        ));
    }
    
    public function resetAllPoints()
    {
        try {
            // Reset semua poin driver ke 0
            Driver::query()->update([
                'total_points' => 0,
                'points_redeemed' => 0
            ]);
            
            // Hapus semua reward records
            Reward::query()->delete();
            
            // Hapus semua transaksi
            Transaction::query()->delete();
            
            // Hapus semua data pasien
            Patient::query()->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Semua data sistem berhasil direset ke 0'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mereset data: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function pointsCount()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        
        // Total poin dari database (sum dari semua driver.total_points)
        $totalPoints = Driver::sum('total_points');
        
        // Total poin yang sudah ditukar (sum dari semua driver.points_redeemed)
        $totalPointsRedeemed = Driver::sum('points_redeemed');
        
        // Sisa poin yang tersedia
        $remainingPoints = $totalPoints - $totalPointsRedeemed;
        
        // Poin yang diberikan hari ini (dari reward yang dibuat hari ini)
        $pointsToday = Reward::whereDate('created_at', $today)->sum('points_spent');
        
        // Poin yang diberikan kemarin
        $pointsYesterday = Reward::whereDate('created_at', $yesterday)->sum('points_spent');
        
        return response()->json([
            'total_points' => $totalPoints,
            'total_points_redeemed' => $totalPointsRedeemed,
            'remaining_points' => $remainingPoints,
            'points_today' => $pointsToday,
            'points_yesterday' => $pointsYesterday
        ]);
    }
    
    public function patientCount()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        
        return response()->json([
            'total_patients' => Patient::count(),
            'new_patients_today' => Patient::whereDate('created_at', $today)->count(),
            'new_patients_yesterday' => Patient::whereDate('created_at', $yesterday)->count()
        ]);
    }
    
    public function scanCount()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        
        // Gunakan logic yang sama dengan ScanController untuk konsistensi
        $queryToday = Transaction::whereDate('scan_time', $today)
            ->where('status', 'CONFIRMED')
            ->whereHas('patient', function($q) {
                $q->whereNotNull('patient_name')
                  ->where('patient_name', '!=', '')
                  ->whereNotNull('patient_condition')
                  ->where('patient_condition', '!=', '');
            });
            
        $queryYesterday = Transaction::whereDate('scan_time', $yesterday)
            ->where('status', 'CONFIRMED')
            ->whereHas('patient', function($q) {
                $q->whereNotNull('patient_name')
                  ->where('patient_name', '!=', '')
                  ->whereNotNull('patient_condition')
                  ->where('patient_condition', '!=', '');
            });
        
        return response()->json([
            'scans_today' => $queryToday->count(),
            'scans_yesterday' => $queryYesterday->count()
        ]);
    }
    
    public function patientChartData(Request $request)
    {
        $period = $request->get('period', 7);
        $endDate = Carbon::today();
        $startDate = $endDate->copy()->subDays($period - 1);
        
        // Ambil data pasien per hari
        $patientData = [];
        $totalPatientsData = [];
        $labels = [];
        
        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $dateStr = $date->format('Y-m-d');
            $label = $date->format('d M');
            
            // Hitung total pasien kumulatif hingga tanggal tersebut
            $totalPatients = Patient::whereDate('created_at', '<=', $dateStr)->count();
            
            // Hitung pasien baru pada tanggal tersebut
            $newPatients = Patient::whereDate('created_at', $dateStr)->count();
            
            $labels[] = $label;
            $totalPatientsData[] = $totalPatients;
            $patientData[] = $newPatients;
        }
        
        return response()->json([
            'success' => true,
            'labels' => $labels,
            'totalPatients' => $totalPatientsData,
            'newPatients' => $patientData,
            'currentTotal' => Patient::count()
        ]);
    }
    
    public function monthlyPatientData()
    {
        $currentYear = Carbon::now()->year;
        $monthlyData = [];
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
        for ($month = 1; $month <= 12; $month++) {
            $count = Patient::whereYear('created_at', $currentYear)
                           ->whereMonth('created_at', $month)
                           ->count();
            $monthlyData[] = $count;
        }
        
        return response()->json([
            'success' => true,
            'labels' => $labels,
            'data' => $monthlyData,
            'year' => $currentYear
        ]);
    }
    
    public function patientDestinationData()
    {
        $igdCount = Patient::where('destination', 'IGD')->count();
        $ponekCount = Patient::where('destination', 'Ponek')->count();
        $total = $igdCount + $ponekCount;
        
        return response()->json([
            'success' => true,
            'data' => [$igdCount, $ponekCount],
            'labels' => ['IGD', 'Ponek'],
            'total' => $total,
            'percentages' => [
                'igd' => $total > 0 ? round(($igdCount / $total) * 100, 1) : 0,
                'ponek' => $total > 0 ? round(($ponekCount / $total) * 100, 1) : 0
            ]
        ]);
    }
    
    private function getRecentActivities()
    {
        $activities = [];
        
        // Ambil driver terbaru
        $recentDrivers = Driver::latest()->take(3)->get();
        foreach ($recentDrivers as $driver) {
            $activities[] = [
                'title' => 'Driver baru terdaftar',
                'subtitle' => $driver->name . ' • ID: ' . $driver->driver_id_card,
                'time' => $driver->created_at->diffForHumans(),
                'icon' => '<svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>',
                'color' => 'bg-blue-100',
                'timestamp' => $driver->created_at
            ];
        }
        
        // Ambil scan terbaru
        $recentScans = Transaction::with(['driver', 'patient'])
            ->latest()
            ->take(3)
            ->get();
            
        foreach ($recentScans as $scan) {
            $activities[] = [
                'title' => 'Scan berhasil',
                'subtitle' => ($scan->driver ? $scan->driver->name : 'Driver tidak ditemukan') . 
                            ' → ' . 
                            ($scan->patient ? $scan->patient->name : 'Pasien tidak ditemukan'),
                'time' => $scan->created_at->diffForHumans(),
                'icon' => '<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                'color' => 'bg-green-100',
                'timestamp' => $scan->created_at
            ];
        }
        
        // Ambil pasien terbaru
        $recentPatients = Patient::latest()->take(2)->get();
        foreach ($recentPatients as $patient) {
            $activities[] = [
                'title' => 'Pasien baru ditambahkan',
                'subtitle' => $patient->name . ' • No. RM: ' . $patient->medical_record_number,
                'time' => $patient->created_at->diffForHumans(),
                'icon' => '<svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
                'color' => 'bg-purple-100',
                'timestamp' => $patient->created_at
            ];
        }
        
        // Urutkan berdasarkan timestamp terbaru
        usort($activities, function($a, $b) {
            return $b['timestamp'] <=> $a['timestamp'];
        });
        
        // Ambil hanya 5 aktivitas terbaru
        return array_slice($activities, 0, 5);
    }
}