<?php

namespace App\Http\Controllers;

use App\Models\Mechanics;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MechanicsController extends Controller
{
    public function index()
    {
        return view('mechanic.index');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mechanics_name' => 'required|string|max:255',
            'contact' => 'required|numeric',
            'email' => 'nullable|email',
            'description' => 'nullable|string',
            'status' => 'required|string|in:pending,active,inactive',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }
        
        $mechanic = new Mechanics();
        $mechanic->fill($validator->validated());
        $mechanic->save();
        
        return response()->json(['success' => true, 'message' => 'Mechanic created successfully.'], 200);
        
    }

    public function mechanics()
    {
        $mechanics = Mechanics::orderByRaw("CASE WHEN isdel = 'active' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json([
            'mechanics' => $mechanics, 
            'message' => 'asdasdasdad', 

        ]);
    }


    public function delete(Request $request)
    {
        $id = $request->id;
        Mechanics::find($id)->update([
            'isdel' => 'deleted',
        ]);
        return response()->json([
            'message' => 'Mechanic deleted successfully',
        ]);
}

    
 
public function edit(Request $request)
{
    try {
        $validatedData = $request->validate([
            'mechanics_name' => 'required|string',
            'contact' => 'required|string',
            'email' => 'required|email',
            'description' => 'nullable|string',
            'status' => 'required',
        ]);
    } catch (ValidationException $e) {
        return response()->json(['message' => $e->getMessage()], 422);
    }

    $id = $request->input('id');
    $mechanics = Mechanics::find($id);
    if (!$mechanics) {
        return response()->json(['message' => 'Mechanic not found'], 404);
    }

    $mechanics->fill($validatedData);
    $mechanics->save();

    return response()->json(['message' => 'Mechanic updated successfully'], 200);
}

}

