<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('department.index');
    }

    public function create(Request $request)
    {
        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            $errors = $validator->errors();

            $response = [
                'message' => 'Validation failed',
                'errors' => [
                    'name' => $errors->first('name'),
                    'description' => $errors->first('description'),
                ],
            ];

            return response()->json($response, 422);
        }

        // If validation passes, create a new user
        $department = new Department();
        $department->name = $request->name;
        $department->description = $request->description;

        // Save the user to the database
        $department->save();

        // Return a success response
        return response()->json([
            'message' => 'success',
            'department' => $department,
        ], 201); // Created status code
    }


    public function datausers()
    {
        $departments = Department::orderByRaw("CASE WHEN isdel = 'active' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc')
            ->get();


        return response()->json([
            'departments' => $departments,
        ]);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        Department::find($id)->update([
            'isdel' => 'deleted',
        ]);
        return response()->json([
            'message' => $request->id,
        ]);
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $description = $request->description;
    
        try {
            // Validation rules
            $rules = [
                'name' => [
                    'required',
                    'string',
                    Rule::unique('departments')->ignore($id),
                ],
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
    
            // Find the department by ID
            $department = Department::findOrFail($id);
    
            // Update the department's name and description
            $department->name = $name;
            $department->description = $description;
    
            // Save the changes to the database
            $department->save();
    
            return response()->json([
                'message' => 'success',
                'department' => $department // Optionally return the updated department object
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'failed' . $e->getMessage()
            ], 500); // Internal Server Error status code
        }
    }
    
}

