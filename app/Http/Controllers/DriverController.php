<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Driver::query();

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('driver_id_card', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');
        
        // Tambahkan eager loading untuk relasi rewards
        $query->with('rewards')
              ->orderBy($sortBy, $sortOrder);

        $drivers = $query->paginate(10)->withQueryString();
        
        // Debug: Cek data driver pertama
        if ($drivers->isNotEmpty()) {
            $firstDriver = $drivers->first();
            \Log::info('Driver data:', [
                'id' => $firstDriver->id,
                'name' => $firstDriver->name,
                'total_points' => $firstDriver->total_points,
                'rewards_count' => $firstDriver->rewards->count(),
                'points_spent_sum' => $firstDriver->rewards->sum('points_spent')
            ]);
        }

        return view('driver.index', compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('driver.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:drivers,phone_number',
            'instansi' => 'required|string|max:255'
        ], [
            'name.required' => 'Nama driver wajib diisi.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'phone_number.unique' => 'Nomor telepon sudah terdaftar.',
        ]);

        // Set driver_id_card sama dengan phone_number
        $validated['driver_id_card'] = $validated['phone_number'];
        $validated['total_points'] = 0;

        Driver::create($validated);

        return redirect()->route('driver.index')->with('success', 'Driver berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function show(Driver $driver)
    {
        return view('driver.show', compact('driver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function edit(Driver $driver)
    {
        return view('driver.edit', compact('driver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:drivers,phone_number,' . $driver->id,
            'instansi' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama driver wajib diisi.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'phone_number.unique' => 'Nomor telepon sudah terdaftar.',
        ]);

        // Set driver_id_card sama dengan phone_number
        $validated['driver_id_card'] = $validated['phone_number'];

        $driver->update($validated);

        return redirect()->route('driver.index')->with('success', 'Driver berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy(Driver $driver)
    {
        $driver->delete();

        return redirect()->route('driver.index')->with('success', 'Driver berhasil dihapus!');
    }

    /**
     * Show all QR codes for all drivers
     *
     * @return \Illuminate\Http\Response
     */
    public function qrcodeAll()
    {
        $drivers = Driver::orderBy('name', 'asc')->get();
        
        return view('driver.qrcode', compact('drivers'));
    }

    /**
     * Show single QR code for specific driver
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function qrcodeSingle(Driver $driver)
    {
        return view('driver.qrcode-single', compact('driver'));
    }
}
