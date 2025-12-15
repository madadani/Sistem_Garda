<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of patients
     */
    public function index(Request $request)
    {
        $query = Patient::with(['transaction.driver']);

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('patient_name', 'like', "%{$search}%")
                  ->orWhere('patient_condition', 'like', "%{$search}%");
            });
        }

        // Filter by destination
        if ($request->has('destination') && $request->destination !== 'ALL') {
            $query->where('destination', $request->destination);
        }

        $patients = $query->orderBy('arrival_time', 'desc')->paginate(10)->withQueryString();

        return view('patient.index', compact('patients'));
    }

    /**
     * Display the specified patient
     */
    public function show($id)
    {
        $patient = Patient::with(['transaction.driver', 'transaction.confirmedBy'])->findOrFail($id);
        
        return view('patient.show', compact('patient'));
    }

    /**
     * Remove the specified patient from storage
     */
    public function destroy(Patient $patient)
    {
        try {
            $patient->delete();
            return redirect()->route('patient.index')->with('success', 'Data pasien berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('patient.index')->with('error', 'Gagal menghapus data pasien. Silakan coba lagi.');
        }
    }

    /**
     * Show the form for editing the specified patient
     */
    public function edit(Patient $patient)
    {
        $patient->load(['transaction.driver']);
        return view('patient.edit', compact('patient'));
    }

    /**
     * Update the specified patient in storage
     */
    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'patient_name' => 'nullable|string|max:255',
            'patient_condition' => 'nullable|string|max:1000',
            'destination' => 'required|in:IGD,Ponek',
            'arrival_time' => 'required|date',
        ]);

        try {
            $patient->update([
                'patient_name' => $request->patient_name,
                'patient_condition' => $request->patient_condition,
                'destination' => $request->destination,
                'arrival_time' => $request->arrival_time,
            ]);

            return redirect()->route('patient.show', $patient)->with('success', 'Data pasien berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('patient.edit', $patient)->with('error', 'Gagal memperbarui data pasien. Silakan coba lagi.');
        }
    }
}
