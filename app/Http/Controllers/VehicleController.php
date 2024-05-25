<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    public function index()
    {
        $driver = Driver::all();
        return view('vehicle.index', compact('driver'));
    }

    public function create(Request $request)
    {
        // Custom validation rule for unique driver name and driver license combination
        $validator = Validator::make($request->all(), [
            'platenumber' => 'required|string|max:20',
            'type' => 'required|string|max:20',
            'name' => 'required|string|max:30',
            'condition' => 'required|string|max:30',
            'description' => 'nullable|string|max:30',
            'status' => 'required|string',
            'drivers_id' => 'nullable|exists:drivers,id',
        ]);

        // Check if a vehicle with the same driver name and driver license already exists
        $driver = Driver::find($request->drivers_id);
        if ($driver) {
            $existingVehicle = Vehicle::whereHas('driver', function ($query) use ($driver) {
                $query->where('driver_name', $driver->driver_name)
                      ->where('driver_license', $driver->driver_license);
            })->first();

            if ($existingVehicle) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => ['drivers_id' => 'The combination of driver name and driver license is already taken.'],
                ], 422);
            }
        }

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $vehicle = new Vehicle();
        $vehicle->platenumber = $request->platenumber;
        $vehicle->type = $request->type;
        $vehicle->name = $request->name;
        $vehicle->condition = $request->condition;
        $vehicle->description = $request->description;
        $vehicle->status = $request->status;
        $vehicle->drivers_id = $request->drivers_id;
     


        $vehicle->save();

        return response()->json([
            'message' => 'Record created successfully',
            'vehicle' => $vehicle,
        ], 201);
    }

    public function datausers()
    {
        $vehicles = DB::table('vehicles')
            ->join('drivers', 'vehicles.drivers_id', '=', 'drivers.id')
            ->select(
                'vehicles.id as id',
                'drivers.driver_name as driver_name',
                'drivers.driver_license as driver_license',
                'vehicles.platenumber',
                'vehicles.type',
                'vehicles.name',
                'vehicles.condition',
                'vehicles.description',
                'vehicles.status',
                'vehicles.created_at',
                'vehicles.updated_at',
                'vehicles.isdel'
            )
            ->orderByRaw("CASE WHEN vehicles.isdel = 'active' THEN 0 ELSE 1 END")
            ->orderBy('vehicles.created_at', 'desc')
            ->get();

        return response()->json([
            'vehicles' => $vehicles,
        ]);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        Vehicle::find($id)->update([
            'isdel' => 'deleted',
        ]);
        return response()->json([
            'message' => 'Vehicle marked as deleted',
        ]);
    }

    public function edit(Request $request)
    {
        try {
            // Validation rules
            $rules = [
                'platenumber' => 'required|string|max:20',
                'type' => 'required|string|max:20',
                'name' => 'required|string|max:30',
                'condition' => 'required|string|max:30',
                'description' => 'nullable|string|max:30',
                'status' => 'required|string',
                'drivers_id' => 'nullable|exists:drivers,id',
            ];
    
            // Validate the request data
            $validator = Validator::make($request->all(), $rules);
    
            // Check if validation fails
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422); // Unprocessable Entity status code
            }
    
            // Find the vehicle by ID
            $vehicle = Vehicle::findOrFail($request->id);
    
            // Update the vehicle attributes
            $vehicle->update($request->all());
    
            return response()->json([
                'message' => 'Record updated successfully',
                'vehicle' => $vehicle // Optionally return the updated vehicle object
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Update failed',
                'error' => $e->getMessage()
            ], 500); // Internal Server Error status code
        }
    }

    public function showTable()
    {
        $vehicles = Vehicle::orderByRaw("CASE WHEN isdel = 'active' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.user.user', ['vehicles' => $vehicles]);
    }
}
