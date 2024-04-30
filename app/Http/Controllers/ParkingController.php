<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use Illuminate\Http\Request;

class ParkingController extends Controller
{
    public function index()
    {
        $parkingSpots = Parking::all();
        return view('parking.index', compact('parkingSpots'));
    }

    public function toggleAvailability(Request $request, $id)
{
    $parkingSpot = Parking::find($id);
    $parkingSpot->available = $request->input('available', true);
    $parkingSpot->name = $request->input('vehicleName', '');
    $parkingSpot->save();

    return response()->json(['message' => 'Spot updated successfully']);
}
}