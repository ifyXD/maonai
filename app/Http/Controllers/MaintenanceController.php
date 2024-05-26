<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\MechanicMaintenance;
use App\Models\Mechanics;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MaintenanceController extends Controller
{
    public function index()
    {

        $mechanics = Mechanics::orderBy('mechanics_name', 'asc')->get();
        $vehicles = Vehicle::orderBy('type', 'asc')->get();
        return view('maintenances.index', compact('mechanics', 'vehicles'));
    }

    public function create(Request $request)
    {

        $rules = [
            'vehicle_id' => 'required',
            'evaluation' => 'required|string',
            'condition' => 'required|string',
            'timestarted' => 'required|date',
            'timefinish' => 'required|date',
            'status' => 'required|in:pending,ongoing,completed',

            'mechanic_ids' => 'required|array',
            'mechanic_ids.*' => 'required|exists:mechanics,id',
            'mechanics.*.mechanic_name' => 'required|string',
        ];



        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'failed',
                'errors' => $validator->errors(),
            ], 422); // Unprocessable Entity status code
        }

        // If validation passes, create a new user
        $maintenances = new Maintenance();
        $maintenances->vehicle_id = $request->vehicle_id;
        $maintenances->evaluation = $request->evaluation;
        $maintenances->condition = $request->condition;
        $maintenances->timestarted = $request->timestarted;
        $maintenances->timefinish = $request->timefinish;
        $maintenances->status = $request->status;
        $maintenances->save();




        foreach ($request->mechanic_ids as $id) {

            $mechanic = Mechanics::find($id);


            MechanicMaintenance::create([
                'maintenance_id' => $maintenances->id,
                'mechanic_id' => $id,
                'mechanic_name' => $mechanic->mechanics_name,
            ]);
        }
        // Return a success response
        return response()->json([
            'message' => 'success',
            'maintenances' => $maintenances,
        ], 201); // Created status code



    }


    public function maintenance()
    {
        $maintenances = Maintenance::select('maintenances.*')
            ->join('vehicles', 'maintenances.vehicle_id', 'vehicles.id')
            // ->join('mechanic_maintenances', 'maintenances.id', 'mechanic_maintenances.maintenance_id')
            ->orderByRaw("CASE WHEN maintenances.isdel = 'active' THEN 0 ELSE 1 END")
            ->orderBy('maintenances.created_at', 'desc')
            ->get();



        return response()->json(['maintenances' => $maintenances]);
    }
    public function delete(Request $request)
    {
        $id = $request->id;
        Maintenance::find($id)->update([
            'isdel' => 'deleted',
        ]);
        return response()->json([
            'message' => $request->id,
        ]);
    }
    public function edit(Request $request)
    {
        $id = $request->id;
        $timefinish = $request->timefinish;
        $evaluation = $request->evaluation;
        $condition = $request->condition;
        $status = $request->status;

        try {
            // Validation rules
            $rules = [
                'evaluation' => 'required|string',
                'condition' => 'required|string',
                'timefinish' => 'required|date',
                'status' => 'required', // Assuming 'status' can only be 'pending' or 'completed'
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

            // Find the maintenance record by ID
            $maintenance = Maintenance::findOrFail($id);

            // Update the maintenance attributes
            $maintenance->update([
                'timefinish' => $timefinish,
                'evaluation' => $evaluation,
                'condition' => $condition,
                'status' => $status,
            ]);

            return response()->json([
                'message' => 'Maintenance updated successfully',
                'maintenance' => $maintenance // Optionally return the updated maintenance object
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update maintenance: ' . $e->getMessage()
            ], 500); // Internal Server Error status code
        }
    }
}
