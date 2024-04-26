<?php

namespace App\Http\Controllers;

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
            'evaluation' => 'required|string',
            'condition' => 'required|string',
            'timefinish' => 'required|date',
            'status' => 'required|', // Assuming 'status' can only be 'pending' or 'completed'
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
    $maintenances->evaluation = $request->evaluation;
    $maintenances->timefinish = $request->timefinish;
    $maintenances->condition = $request->condition;
    $maintenances->status = $request->status;
    $maintenances->save();
    // Return a success response
    return response()->json([
        'message' => 'success',
        'maintenances' => $maintenances,
    ], 201); // Created status code
}


public function maintenance()
{
    $maintenances = Maintenance::orderByRaw("CASE WHEN isdel = 'active' THEN 0 ELSE 1 END")
    ->orderBy('created_at', 'desc')
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
