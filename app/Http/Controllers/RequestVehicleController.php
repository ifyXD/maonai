<?php

namespace App\Http\Controllers;

use App\Models\requestVehicle;
use App\Models\YourModel; // Replace YourModel with your actual model name
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class YourController extends Controller
{
    public function index()
    {
        return view('requestvehicles.index'); // Replace your_view with your actual view name
    }

    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'vehicle_id' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'appointment' => 'required|date',
        ];

        $validatedData = $request->validate($rules);

        $requestVehicle = requestVehicle::create($validatedData);

        return response()->json([
            'message' => 'Record created successfully',
            'data' => $requestVehicle,
        ], 201);
        
    }

    public function store(){

        return view('requestvehicles.create');
    }

    public function allRecords()
    {
        $requestVehicle = requestVehicle::orderBy('created_at', 'desc')->get();

        return response()->json([
            'records' => $requestVehicle,
        ]);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        requestVehicle::find($id)->delete();

        return response()->json([
            'message' => 'Record deleted successfully',
        ]);
    }

    public function edit(Request $request)
    {
        try {
            $rules = [
                'name' => 'required|string|max:255',
                'vehicle_id' => 'required|string|max:255',
                'user_id' => 'required|string|max:255',
                'purpose' => 'required|string|max:255',
                'status' => 'required|string|max:255',
                'appointment' => 'required|date',
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
