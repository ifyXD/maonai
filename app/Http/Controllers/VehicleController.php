<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Fuel;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    public function index()
    {
        $drivers = Driver::where('isdel', 'active')->orderBy('driver_name', 'asc')->get();
        $fuels = Fuel::orderBy('fuel_type', 'asc')->get();
        return view('vehicle.index', compact('drivers', 'fuels'));
    }

    public function create(Request $request)
    {
        // Custom validation rule for unique driver name and driver license combination
        $rules = [
            'platenumber' => 'required|string|max:20',
            'seat_capacity' => 'required|integer',
            'type' => 'required|string|max:20',
            'driver_id' => 'nullable|integer|unique:vehicles,driver_id,NULL,id',
            'fuel_id' => 'nullable|integer',
            'description' => 'nullable|string|max:30',
            'status' => 'required|string',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // If validation passes, create a new vehicle
        $vehicle = new Vehicle();
        $vehicle->platenumber = $request->platenumber;
        $vehicle->seat_capacity = $request->seat_capacity;
        $vehicle->type = $request->type;
        $vehicle->driver_id = $request->driver_id;
        $vehicle->fuel_id = $request->fuel_id;
        $vehicle->description = $request->description;
        $vehicle->status = $request->status;

        // Save the vehicle to the database
        $vehicle->save();

        // Return a success response
        return response()->json([
            'message' => 'success',
            'vehicle' => $vehicle,
        ], 201);
    }

    public function datausers()
    {
        $vehicles = DB::table('vehicles')
            ->leftJoin('drivers', 'vehicles.driver_id', '=', 'drivers.id')
            ->leftJoin('fuels', 'vehicles.fuel_id', '=', 'fuels.id') // Uncomment and correct if needed
            ->select(
                'vehicles.id as vid',
                'vehicles.created_at as created_at',
                'vehicles.updated_at as updated_at',
                'vehicles.platenumber',
                'vehicles.type',
                'vehicles.driver_id',
                'vehicles.fuel_id',
                'vehicles.description as description',
                'vehicles.seat_capacity as seat_capacity',
                'vehicles.status as vstatus',
                'vehicles.isdel as visdel',
                'drivers.id as driver_id',
                'drivers.driver_name',
                'drivers.contact',
                'drivers.email',
                'drivers.driver_license',
                'drivers.address',
                'drivers.status as driver_status',
                'fuels.*',
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
                'driver_id' => 'nullable|string|max:30|unique:vehicles,driver_id,' . $request->id . ',id',
                'fuel_id' => 'nullable|integer',
                'description' => 'required|string|max:30',
                'seat_capacity' => 'required|integer',
                'status' => 'required|string',
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
