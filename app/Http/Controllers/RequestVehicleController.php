<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class RequestVehicleController extends Controller
{
    public function index(){


        return view('requestvehicle.index');
    }


    public function create(Request $request){

        $rules = [
            'platenumber' => 'required|string|max:20|',
            'vehicle_id' => 'required|string|max:20',
            'driver' => 'required|string|max:30',
            'condition' => 'required|string|max:30',
            'description' => 'nullable|string|max:30',
            'status' => 'required|string',

        ];
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'failed',
                'errors' => $validator->errors(),
            ], 422); // Unprocessable Entity status code
        }
    }
}
