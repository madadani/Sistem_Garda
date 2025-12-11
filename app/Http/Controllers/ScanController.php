<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Reward;
use App\Events\ScanCreated;

class ScanController extends Controller
{
    /**
     * Display a listing of pending scans
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['driver', 'patient']);

        // Hanya tampilkan yang statusnya CONFIRMED (Selesai)
        $query->where('status', 'CONFIRMED');

        // Hanya tampilkan transaksi yang memiliki data pasien lengkap
        $query->whereHas('patient', function($q) {
            $q->whereNotNull('patient_name')
              ->where('patient_name', '!=', '')
              ->whereNotNull('patient_condition')
              ->where('patient_condition', '!=', '');
        });

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('driver', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('driver_id_card', 'like', "%{$search}%");
            });
        }

        $transactions = $query->orderBy('scan_time', 'desc')->paginate(10)->withQueryString();
        
        // Count pending untuk notifikasi
        $pendingCount = Transaction::pending()->count();

        return view('scan.index', compact('transactions', 'pendingCount'));
    }

    /**
     * Show confirmation form
     */
    public function confirm($id)
    {
        $transaction = Transaction::with('driver')->findOrFail($id);
        
        if ($transaction->status !== 'PENDING') {
            return redirect()->route('scan.index')->with('error', 'Transaksi sudah dikonfirmasi atau ditolak.');
        }

        return view('scan.confirm', compact('transaction'));
    }

    /**
     * Process confirmation and add patient data
     */
    public function processConfirm(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        
        if ($transaction->status !== 'PENDING') {
            return redirect()->route('scan.index')->with('error', 'Transaksi sudah dikonfirmasi atau ditolak.');
        }

        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_condition' => 'required|string',
            'destination' => 'required|in:IGD,Ponek',
        ], [
            'patient_name.required' => 'Nama pasien wajib diisi.',
            'patient_condition.required' => 'Keluhan pasien wajib diisi.', 
            'destination.required' => 'Tujuan pasien wajib dipilih.',
            'destination.in' => 'Tujuan hanya boleh IGD atau Ponek.',
        ]);

        // Update transaction status
        $transaction->update([
            'status' => 'CONFIRMED',
            'confirmed_by_admin_id' => auth()->id(),
        ]);

        // Create patient record
        $transaction->patient()->create([
            'patient_name' => $validated['patient_name'],
            'patient_condition' => $validated['patient_condition'],
            'destination' => $validated['destination'],
            'arrival_time' => now(),
        ]);

        

        // Add points to driver
        $driver = $transaction->driver;
        $driver->increment('total_points', $transaction->points_awarded);

        Reward::create([
            'driver_id'     => $driver->id,
            'convert_point' => Reward::POINT_VALUE,
            'points_spent'  => $transaction->points_awarded,
            'status'        => 'completed',
        ]);


        return redirect()->route('scan.index')->with('success', 'Scan berhasil dikonfirmasi! Driver mendapat +' . $transaction->points_awarded . ' poin.');
    }

    /**
     * Reject scan
     */
    public function reject(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        
        if ($transaction->status !== 'PENDING') {
            return redirect()->route('scan.index')->with('error', 'Transaksi sudah dikonfirmasi atau ditolak.');
        }

        $transaction->update([
            'status' => 'REJECTED',
            'confirmed_by_admin_id' => auth()->id(),
        ]);

        return redirect()->route('scan.index')->with('warning', 'Scan ditolak. Tidak ada poin yang diberikan.');
    }

    /**
     * Get pending count for notification badge
     */
    public function getPendingCount()
    {
        return response()->json([
            'count' => Transaction::pending()->count()
        ]);
    }
}
