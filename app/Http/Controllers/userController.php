<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    public function index(){
    
        return view('users.create');


    }

    public function store(){

        $users = User::all();
    return view('users.all', ['users' => $users]);

    }

    public function destroy(){
        return view('users.destroy');
    }


    public function tableusers()
    {
        $users = User::orderByRaw("CASE WHEN isdel = 'active' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc')
            ->get();


        return response()->json([
            'users' => $users,
        ]);
    }
    

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'ufname' => 'required|string|max:255',
            'uname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
    
        $user = new User([
            'ufname' => $request->input('ufname'),
            'uname' => $request->input('uname'),
            'lname' => $request->input('lname'),
            'address' => $request->input('address'),
            'contact' => $request->input('contact'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
        ]);
    
        $user->save();
    
        // Optionally, you can return a success message here
        return response()->json(['message' => 'success'], 200);
    }

    public function edit(Request $request, User $user){
        $validator = Validator::make($request->all(), [
            'ufname' => 'required|string|max:255',
            'uname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'password' => 'nullable|string|min:6', // Change to nullable for non-required password
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $user->ufname = $request->input('ufname');
        $user->uname = $request->input('uname');
        $user->lname = $request->input('lname');
        $user->address = $request->input('address');
        $user->contact = $request->input('contact');
        $user->username = $request->input('username');
    
        // Check if password is provided and hash it
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
    
        $user->save();
    
        // Optionally, you can redirect to a success page or return a success message here
        return response()->json(['message' => 'User updated successfully'], 200);
    }
    
    


    public function delete(Request $request)
    {
        $id = $request->id;
        User::find($id)->update([
            'isdel' => 'deleted',
        ]);
        return response()->json([       
            'message' => $request->id,
        ]);
    }

    
    }


