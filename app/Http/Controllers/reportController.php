<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Fuel;
use App\Models\Maintenance;
use App\Models\Mechanics;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class reportController extends Controller
{
    public function index(){
        $driver= Driver::count();
        $mechanicsCount = Mechanics::count();
        $vehicles = Fuel::sum('fuel_cost');
        $vehiclesdata = Vehicle::count();
        $maintenance = Maintenance::count();

        return view('reports.index', compact('vehicles', 'mechanicsCount','driver','vehiclesdata','maintenance'));
    }
}
