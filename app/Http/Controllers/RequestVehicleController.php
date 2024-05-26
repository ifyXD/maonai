<?php

namespace App\Http\Controllers;

use App\Models\requestVehicle;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\YourModel; // Replace YourModel with your actual model name
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RequestVehicleController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status?? 'pending';

        $query = RequestVehicle::where('user_id', auth()->user()->id);

        if ($status) {
            $query->where('status', $status);
        }

        $myrequests = $query->orderBy('created_at', 'desc')->get();

        return view('requestvehicles.index', compact('myrequests', 'status'));
    }

    public function store()
    {
        $vehicle = Vehicle::all();
        $requestvehicle = requestVehicle::all();

        return view('requestvehicles.create', compact('vehicle', 'requestvehicle'));
    }

    public function createRequest(Request $request)
    {

        $vehicle = Vehicle::find($request->vehicle_id);

        // Create a new RequestVehicle instance
        $requestVehicle = new RequestVehicle();
        $requestVehicle->name = $request->username;
        $requestVehicle->vehicle_id = $request->vehicle_id;
        $requestVehicle->capacity = $request->capacity;
        $requestVehicle->purpose = $request->purpose;
        $requestVehicle->status = 'pending';
        $requestVehicle->user_id = auth()->user()->id;
        $requestVehicle->drivers_id = $vehicle->driver_id;
        $requestVehicle->appointment = $request->appointment;
        $requestVehicle->appointment_end = $request->appointment_end;

        // Save the new RequestVehicle record
        $requestVehicle->save();

        // Optionally, return a success response or redirect back
        return redirect()->route('all-requests.user')->with('message', 'Your request has been submitted');
    }




    public function allRecords()
    {
        if (auth()->user()->role === 'admin') {
            $requestVehicles = DB::table('request_vehicles')
                ->join('vehicles', 'request_vehicles.vehicles_id', 'vehicles.id')
                ->select('request_vehicles.*', 'vehicles.type', 'vehicles.condition', 'vehicles.platenumber',)
                ->orderByRaw("CASE WHEN isdel = 'active' THEN 0 ELSE 1 END")
                ->orderBy('request_vehicles.created_at', 'desc')
                ->get();
        } else {
            $requestVehicles = DB::table('request_vehicles')
                ->join('vehicles', 'request_vehicles.vehicles_id', 'vehicles.id')
                ->select('request_vehicles.*', 'vehicles.type', 'vehicles.condition', 'vehicles.platenumber',)
                ->where('request_vehicles.user_id', auth()->user()->id)
                ->orderByRaw("CASE WHEN isdel = 'active' THEN 0 ELSE 1 END")
                ->orderBy('request_vehicles.created_at', 'desc')
                ->get();
        }

        return response()->json([
            'records' => $requestVehicles,
        ]);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $requestVehicle = requestVehicle::find($id);

        if (!$requestVehicle) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        if (auth()->user()->role !== 'admin' && $requestVehicle->user_id !== auth()->user()->id) {
            return response()->json([
                'message' => 'You are not authorized to delete this record',
            ], 403);
        }

        $requestVehicle->delete();

        return response()->json([
            'message' => 'Record deleted successfully',
        ]);
    }


    public function edit(Request $request)
    {
        try {
            $rules = [
                'vehicle_id' => 'required|string|max:255',
                'user_id' => 'required|string|max:255',
                'purpose' => 'required|string|max:255',
                'status' => 'required|string|max:255',
                'appointment' => 'required|date',
                'capacity' => 'required|integer',

            ];

            $validatedData = $request->validate($rules);
            $requestVehicle = requestVehicle::findOrFail($request->id);
            $requestVehicle->update($validatedData);

            return response()->json([
                'message' => 'Record updated successfully',
                'data' => $requestVehicle,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update record',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
