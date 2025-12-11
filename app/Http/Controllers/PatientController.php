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
}
