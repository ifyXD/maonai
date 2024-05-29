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
        $status = $request->status ?? 'all';

        if ($status == 'all' || $status == 'pending' || $status == 'accept' || $status == 'decline') {
            $query = RequestVehicle::where('user_id', auth()->user()->id);

            if ($status != 'all') {
                $query->where('status', $status);
            }

            $myrequests = $query->orderBy('created_at', 'desc')->get();
        } else {
            abort(404);
        }

        return view('requestvehicles.index', compact('myrequests', 'status'));
    }

    public function store(Request $request)
    {
        $id = $request->id;

        $myrequest = null;
        if ($request->id != null) {
            $myrequest = requestVehicle::findOrFail($id);
        } else {
            $myrequest = null;
        }
        // $vehicles = Vehicle::where('isdel', 'active')->get();

        $userId = auth()->user()->id;

        // Retrieve all vehicles
        $vehicles = Vehicle::where('isdel', 'active')->get();
    
        // Retrieve all request vehicles with status 'pending' or 'accepted'
        $pendingOrAcceptedRequests = RequestVehicle::whereIn('status', ['pending', 'accept'])
            ->get()
            ->groupBy('vehicle_id');
    
        // Retrieve accepted request vehicles for other users
        $acceptedRequestsForOtherUsers = RequestVehicle::where('status', 'accept')
            ->where('user_id', '!=', $userId)
            ->get()
            ->groupBy('vehicle_id');


        $requestvehicle = requestVehicle::all();

        return view('requestvehicles.create', compact('vehicles', 'requestvehicle', 'myrequest', 'pendingOrAcceptedRequests', 'acceptedRequestsForOtherUsers', 'userId'));
    }

    public function createRequest(Request $request)
    {

        $vehicle = Vehicle::find($request->vehicle_id);

        $id = $request->id;
        if ($request->id != null) {
            $myrequest = requestVehicle::findOrFail($id);

            if ($myrequest->status == 'pending') {
                $myrequest->update([
                    'name' => $request->username,
                    'vehicle_id' => $request->vehicle_id,
                    'capacity' => $request->capacity,
                    'purpose' => $request->purpose,
                    'drivers_id' => $vehicle->driver_id,
                    'appointment' => $request->appointment,
                    'appointment_end' => $request->appointment_end,
                ]);
            } else {
                return redirect()->route('all-requests.user')->with('message', 'Request update failed');
            }
        } else {

            // Check if a RequestVehicle record with the same user_id, vehicle_id, and status (pending or accepted) already exists
            $existingRequest = RequestVehicle::where('user_id', auth()->user()->id)
                ->where('vehicle_id', $request->vehicle_id)
                ->whereIn('status', ['pending', 'accepted'])
                ->first();

            if (!$existingRequest) {
                // Create a new RequestVehicle instance if no such record exists
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
            } else {
                return back()->with('message', 'A similar request for vehicle already exists');
            }
        }


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
