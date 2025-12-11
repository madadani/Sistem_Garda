<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DriversPointExport;

class PointRewardController extends Controller
{
    public function index()
    {
        $drivers = Driver::all();
        return view('dashboard.point_reward', compact('drivers'));
    }

    public function export()
    {
        return Excel::download(new DriversPointExport, 'drivers_point.xlsx');
    }
}
