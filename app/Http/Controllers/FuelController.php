<?php

namespace App\Http\Controllers;

use App\Models\Fuel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FuelController extends Controller
{
    public function index()
    {
        return view('fuel.index');
    }

    public function create(Request $request)
    {
        // Validation rules
        $rules = [
            'fuel_type' => 'required|string|max:20',
            'fuel_quantity' => 'required|numeric',
            'fuel_cost' => 'required|numeric',
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

        // If validation passes, create a new fuel record
        $fuel = new Fuel();
        $fuel->fuel_type = $request->fuel_type;
        $fuel->fuel_quantity = $request->fuel_quantity;
        $fuel->fuel_cost = $request->fuel_cost;
        $fuel->status = $request->status;

        // Save the fuel record to the database
        $fuel->save();

        // Return a success response
        return response()->json([
            'message' => 'success',
            'fuel' => $fuel,
        ], 201); // Created status code
    }

    public function datafuels()
    {
        $fuels = Fuel::orderBy('created_at', 'desc')->get();

        return response()->json([
            'fuels' => $fuels,
        ]);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        Fuel::find($id)->delete();

        return response()->json([
            'message' => 'success',
        ]);
    }

    public function edit(Request $request)
    {
        try {
            // Validation rules
            $rules = [
                'fuel_type' => 'required|string|max:20',
                'fuel_quantity' => 'required|numeric',
                'fuel_cost' => 'required|numeric',
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

            // Find the fuel record by ID
            $fuel = Fuel::findOrFail($request->id);

            // Update the fuel record attributes
            $fuel->update($request->all());

            return response()->json([
                'message' => 'success',
                'fuel' => $fuel, // Optionally return the updated fuel object
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'failed',
                'error' => $e->getMessage(),
            ], 500); // Internal Server Error status code
        }
    }
}
