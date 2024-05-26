<?php

namespace App\Http\Controllers;

use App\Models\Fuel;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class reportController extends Controller
{
    public function index(){


        $vehicles = Fuel::sum('fuel_cost');
        return view('reports.index', compact('vehicles'));

    }
}
