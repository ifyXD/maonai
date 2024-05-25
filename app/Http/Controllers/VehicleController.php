<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    public function index()
    {
        $drivers = Driver::orderBy('driver_name', 'asc')->get();
        return view('vehicle.index', compact('drivers'));
    }

    public function create(Request $request)
    {
        // Validation rules
        $rules = [
            'platenumber' => 'required|string|max:20|',
            'type' => 'required|string|max:20',
            'driver_id' => 'required|string|max:30',
            'condition' => 'required|string|max:30',
            'description' => 'nullable|string|max:30',
            'status' => 'required|string',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'failed',
                'errors' => $validator->errors(),
            ], 422); // Unprocessable Entity status code
        }

        // If validation passes, create a new user
        $vehicle = new Vehicle();
        $vehicle->platenumber = $request->platenumber;
        $vehicle->type = $request->type;
        $vehicle->driver_id = $request->driver_id;
        $vehicle->condition = $request->condition;
        $vehicle->description = $request->description;

        $vehicle->status = $request->status;
        // Save the user to the database
        $vehicle->save();
        // Return a success response
        return response()->json([
            'message' => 'success',
            'vehicle' => $vehicle,
        ], 201); // Created status code
    }


    public function datausers()
    {
        $vehicles = Vehicle::join('drivers', 'vehicles.driver_id', '=', 'drivers.id')
            ->orderByRaw("CASE WHEN vehicles.isdel = 'active' THEN 0 ELSE 1 END")
            ->orderBy('vehicles.created_at', 'desc')
            ->select('vehicles.id as id', 'drivers.id as did','vehicles.*', 'drivers.driver_name') // Ensure to select columns from vehicles to avoid ambiguous column errors
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

        // Driver::find($driverId)->relatedRecords()->update(['driver_id' => null]);
        // Driver::destroy($driverId);
        return response()->json([
            'message' => $request->id,
        ]);
    }
    public function edit(Request $request)
    {
        try {
            // Validation rules
            $rules = [
                'platenumber' => 'required',
                'type' => 'required',
                'driver_id' => 'required',
                'condition' => 'required',
                'description' => 'required',
                'status' => 'required',
            ];

            // Validate the request data
            $validator = Validator::make($request->all(), $rules);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'failed',
                    'errors' => $validator->errors(),
                ], 422); // Unprocessable Entity status code
            }

            // Find the vehicle by ID
            $vehicle = Vehicle::findOrFail($request->id);

            // Update the vehicle attributes
            $vehicle->update($request->all());

            return response()->json([
                'message' => 'success',
                'vehicle' => $vehicle // Optionally return the updated vehicle object
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'failed',
                'error' => $e->getMessage()
            ], 500); // Internal Server Error status code
        }
    }
    public function showTable()
    {
        $vehicles = Vehicle::orderByRaw("CASE WHEN isdel = 'active' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc')
            ->get();
        $vehicles = Vehicle::all();

        return view('dashboard.user.user', ['vehicles' => $vehicles]);
    }
}
