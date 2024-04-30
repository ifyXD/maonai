<?php

namespace App\Http\Controllers;

use App\Models\Fuel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use League\Config\Exception\ValidationException;

class FuelController extends Controller
{
    public function index() {
        return view('fuel.index');

    }
    public function create(Request $request)
{
    $validatedData = $request->validate([
        'date' => 'required|date',
        'fuel_type' => 'required|string',
        'fuel_quantity' => 'required|',
        'fuel_cost' => 'required|',
        'status' => 'required|',
    ]);

    // Create a new Fuel record
    $fuel = new Fuel();
    $fuel->date = $validatedData['date'];
    $fuel->fuel_type = $validatedData['fuel_type'];
    $fuel->fuel_quantity = $validatedData['fuel_quantity'];
    $fuel->fuel_cost = $validatedData['fuel_cost'];
    $fuel->status = $validatedData['status'];
    $fuel->save();

    // Return a success response
    return response()->json(['message' => 'success']);
}
public function fuels()
{
    $fuels = Fuel::orderByRaw("CASE WHEN status = 'active' THEN 0 ELSE 1 END")
        ->orderBy('date', 'desc')
        ->get();
    return response()->json([
        'fuels' => $fuels, 
        'message' => 'Fuel records retrieved successfully',
    ]);
}

public function delete(Request $request)
    {
        $id = $request->id;
        Fuel::find($id)->update([
            'isdel' => 'deleted',
        ]);
        return response()->json([
            'message' => 'Mechanic deleted successfully',
        ]);
}

public function edit(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id' => 'required|exists:fuels',
        'date' => 'required|date',
        'fuel_type' => 'required|string',
        'fuel_quantity' => 'required|numeric',
        'fuel_cost' => 'required|numeric',
        'status' => 'required|string|in:pending,active,inactive',
    ]);
    
    if ($validator->fails()) {
        return response()->json(['message' => $validator->errors()->first()], 422);
    }

    $fuel = Fuel::find($request->id);
    if (!$fuel) {
        return response()->json(['message' => 'Fuel record not found'], 404);
    }

    $fuel->fill($validator->validated());
    $fuel->save();

    return response()->json(['message' => 'Fuel record updated successfully'], 200);
}
}