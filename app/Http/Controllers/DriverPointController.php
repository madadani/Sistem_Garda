<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Transaction;
use App\Models\Reward;
use App\Events\NewScan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DriverPointController extends Controller
{
    /**
     * Show driver points by ID card (public access, no auth)
     * This is accessed when driver scans QR code for viewing points only
     * Does NOT create transaction
     */
    public function showPoints($driverIdCard)
    {
        try {
            // Mencari driver berdasarkan ID card
            $driver = Driver::where('driver_id_card', $driverIdCard)->firstOrFail();
            
            // Mengambil transaksi terakhir
            $latestTransaction = $driver->transactions()
                ->where('status', 'CONFIRMED')
                ->latest('scan_time')
                ->first();

            // Mengambil semua transaksi yang sudah dikonfirmasi dengan relasi patient
            $transactions = $driver->transactions()
                ->with('patient') // Menyertakan relasi patient
                ->where('status', 'CONFIRMED')
                ->orderBy('scan_time', 'desc')
                ->paginate(10); // 10 item per halaman

            return view('driver.point', [
                'driver' => $driver,
                'latestTransaction' => $latestTransaction,
                'transactions' => $transactions
            ]);

        } catch (\Exception $e) {
            // Jika terjadi error, tetap tampilkan halaman dengan data kosong
            $driver = (object)[
                'name' => 'Driver',
                'driver_id_card' => $driverIdCard,
                'phone_number' => '',
                'total_points' => 0,
                'total_confirmed_transactions' => 0
            ];
            
            $transactions = collect([]);
            $latestTransaction = null;
            
            return view('driver.point', [
                'driver' => $driver,
                'latestTransaction' => $latestTransaction,
                'transactions' => $transactions
            ])->with('error', 'Gagal memuat data. Silakan coba lagi.');
        }
    }

    /**
     * Scan barcode to record transaction when driver brings patient to hospital
     * This creates a new transaction automatically
     */
    public function scanTransaction($driverIdCard = null)
    {
        // Handle request untuk membersihkan session data
        if (request()->isMethod('post') && request()->get('action') === 'clear_session_data') {
            session()->forget('patient_input_data');
            return response()->json(['success' => true]);
        }
        
        // Jika tidak ada ID card, redirect ke halaman landing
        if (!$driverIdCard) {
            return redirect()->route('scan.landing')
                ->with('error', 'ID Card tidak ditemukan');
        }
        
        // Bersihkan input
        $cleanId = preg_replace('/[^0-9]/', '', $driverIdCard);
        
        // Cari driver
        $driver = Driver::where('driver_id_card', 'LIKE', "%{$cleanId}%")
            ->orWhere('phone_number', 'LIKE', "%{$cleanId}%")
            ->first();

        if (!$driver) {
            return redirect()->route('driver.not.found');
        }

        // Cek transaksi terakhir
        $latestTransaction = Transaction::where('driver_id', $driver->id)
            ->latest()
            ->first();

        // Buat transaksi baru dengan status CONFIRMED untuk semua scan
        // Selalu buat transaksi baru setiap scan untuk mencatat setiap kunjungan
        $transaction = Transaction::create([
            'transaction_id' => 'TRX-' . strtoupper(Str::random(10)),
            'driver_id' => $driver->id,
            'status' => 'CONFIRMED',
            'scan_time' => now(),
            'points_awarded' => 1,
        ]);
        
        // Kirim event untuk real-time update
        event(new NewScan($transaction));
        
        // Set latestTransaction ke transaksi yang baru dibuat
        $latestTransaction = $transaction;
        
        // Tampilkan halaman sukses dengan data driver dan transaksi terakhir
        return view('driver.scan-success', [
            'driver' => $driver,
            'transaction' => $latestTransaction,
            'latestTransaction' => $latestTransaction
        ]);
    }

    public function validatePatientData(Request $request, $transactionId)
    {
        $transaction = Transaction::with('driver')->findOrFail($transactionId);

        // Validasi input data
        $validated = $request->validate([
            'patient_name' => 'nullable|string|max:255',
            'patient_condition' => 'nullable|string',
            'destination' => 'required|in:IGD,Ponek',
        ], [
            'destination.required' => 'Tujuan pasien wajib dipilih.',
            'destination.in' => 'Tujuan hanya boleh IGD atau Ponek.',
        ]);

        // Simpan data ke session untuk ditampilkan di halaman validasi
        session(['patient_data' => $validated]);
        
        // Simpan data ke session untuk pengembalian ke halaman input
        session(['patient_input_data' => $validated]);

        // Tampilkan halaman validasi
        return view('driver.validate-patient', [
            'transaction' => $transaction,
            'driver' => $transaction->driver,
            'patientData' => $validated
        ]);
    }

    public function storePatientData(Request $request, $transactionId)
    {
        $transaction = Transaction::with('driver', 'patient')->findOrFail($transactionId);

        // Validasi opsional - hanya destination yang wajib
        $validated = $request->validate([
            'patient_name' => 'nullable|string|max:255',
            'patient_condition' => 'nullable|string',
            'destination' => 'required|in:IGD,Ponek',
        ], [
            'destination.required' => 'Tujuan pasien wajib dipilih.',
            'destination.in' => 'Tujuan hanya boleh IGD atau Ponek.',
        ]);

        // Cek apakah data pasien lengkap (nama dan keluhan tidak kosong)
        $hasCompletePatientData = !empty($validated['patient_name']) && !empty($validated['patient_condition']);

        // Buat atau perbarui data pasien yang terhubung dengan transaksi ini
        $transaction->patient()->updateOrCreate([], [
            'patient_name' => $validated['patient_name'],
            'patient_condition' => $validated['patient_condition'],
            'destination' => $validated['destination'],
            'arrival_time' => now(),
        ]);

        // Bersihkan session patient_input_data setelah data tersimpan
        session()->forget('patient_input_data');

        // Berikan poin hanya jika data pasien lengkap
        if ($hasCompletePatientData) {
            $driver = $transaction->driver;
            $driver->increment('total_points', $transaction->points_awarded);

            // Catat reward
            Reward::create([
                'driver_id'     => $driver->id,
                'convert_point' => Reward::POINT_VALUE,
                'points_spent'  => $transaction->points_awarded,
                'status'        => 'completed',
            ]);

            // Buat data notifikasi lengkap
            $notificationData = [
                'patient_name' => $validated['patient_name'],
                'patient_condition' => $validated['patient_condition'],
                'destination' => $validated['destination'],
                'driver_name' => $driver->name,
                'driver_id_card' => $driver->driver_id_card,
                'scan_time' => $transaction->scan_time->format('d/m/Y H:i'),
                'points' => $transaction->points_awarded
            ];

            return redirect()
                ->route('driver.scan', $driver->driver_id_card)
                ->with('success', $notificationData);
        } else {
            // Data pasien tidak lengkap, tidak berikan poin
            return redirect()
                ->route('driver.scan', $driver->driver_id_card)
                ->with('info', 'Data pasien tidak lengkap. Driver tidak mendapatkan poin.');
        }
    }
}
