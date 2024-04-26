<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MaintenanceController extends Controller
{
    public function index()
    {
        return view('maintenances.index');
    }

    public function create(Request $request)
    {
        $rules = [
            'driver_name' => 'required|string',
            'contact' => 'required|string',
            'email' => 'required|email',
            'driver_license' => 'required|string',
            'address' => 'required|string',
            'status' => 'required|in:pending,completed',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $driver = new Driver();
        $driver->driver_name = $request->driver_name;
        $driver->contact = $request->contact;
        $driver->email = $request->email;
        $driver->driver_license = $request->driver_license;
        $driver->address = $request->address;
        $driver->status = $request->status;
        $driver->save();

        return response()->json([
            'message' => 'Driver created successfully',
            'driver' => $driver,
        ], 201);
    }

    public function edit(Request $request)
    {
        $id = $request->id;

        $rules = [
            'driver_name' => 'required|string',
            'contact' => 'required|string',
            'email' => 'required|email',
            'driver_license' => 'required|string',
            'address' => 'required|string',
            'status' => 'required|in:pending,completed',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $driver = Driver::findOrFail($id);
            $driver->update([
                'driver_name' => $request->driver_name,
                'contact' => $request->contact,
                'email' => $request->email,
                'driver_license' => $request->driver_license,
                'address' => $request->address,
                'status' => $request->status,
            ]);

            return response()->json([
                'message' => 'Driver updated successfully',
                'driver' => $driver,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update driver: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        try {
            $driver = Driver::findOrFail($id);
            $driver->delete();

            return response()->json([
                'message' => 'Driver deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete driver: ' . $e->getMessage(),
            ], 500);
        }
    }
}