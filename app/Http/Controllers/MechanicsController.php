<?php

namespace App\Http\Controllers;

use App\Models\Mechanics;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DateTime;

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
        
        // Generate the HTML for the new row
        $html = $this->generateDriverRowsHtml();

        return response()->json([
            'success' => 'success',
            'html' => $html,
        ], 201);
    }

    private function generateDriverRowsHtml()
    {
        $mechanics =  $mechanics = Mechanics::orderByRaw("CASE WHEN isdel = 'active' THEN 0 ELSE 1 END")
        ->orderBy('created_at', 'desc')
        ->get();

        $html = '';
        foreach ($mechanics as $index => $driver) {
            // $createdAt = new DateTime($driver->created_at);
            // $formattedCreatedAt = $createdAt->format('M d, Y');
            $key = $index + 1;
            $ifdel = $driver->isdel === 'isdel' ? 'is-deleted' : '';
            $action = $driver->isdel === 'active' ?
                '<a href="#" class="editMechanic" data-id="' . $driver->id . '" data-bs-toggle="modal" data-bs-target="#mechanicEdit'. $driver->id. '">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                    </svg>
                </a>
                <a href="#" onclick="confirmDelete(' . $driver->id . ');" id="deleteDriver">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash text-danger" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                    </svg>
                </a>' :
                '<span class="text-danger">Deleted</span>';

            $html .= '<tr class="' . $ifdel . '" id="trId' . $driver->id . '">
                        <td>' . $key . '</td>
                        <td id="driver_nameId' . $driver->id . '">' . $driver->mechanics_name . '</td>
                        <td id="contactId' . $driver->id . '">' . $driver->contact . '</td>
                        <td id="emailId' . $driver->id . '">' . $driver->email . '</td>
                        <td id="driver_descriptionId' . $driver->id . '">' . $driver->description . '</td> 
                        <td id="statusId' . $driver->id . '">' . $driver->status . '</td>
                        <td>' . (new DateTime($driver->created_at))->format('M d, Y') . '</td>
                        <td>' . (new DateTime($driver->updated_at))->format('M d, Y') . '</td>
                        <td>
                            ' . $action . '
                            <div class="modal fade" id="mechanicEdit'.$driver->id.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Driver</h1>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body"> 
                                            <div class="mb-3">
                                                <label for="editdriver_name' . $driver->id . '" class="form-label">Driver Name</label>
                                                <input type="text" value="' . $driver->mechanics_name . '" class="form-control" id="editmechanics' . $driver->id . '" aria-describedby="emailHelp"> 
                                            </div>
                                            <div class="mb-3">
                                                <label for="editcontact' . $driver->id . '" class="form-label">Contact</label>
                                                <input type="number" value="' . $driver->contact . '" class="form-control" id="editcontact' . $driver->id . '" aria-describedby="emailHelp"> 
                                            </div>
                                            <div class="mb-3">
                                                <label for="editemail' . $driver->id . '" class="form-label">Email</label>
                                                <input type="email" value="' . $driver->email . '" class="form-control" id="editemail' . $driver->id . '" aria-describedby="emailHelp"> 
                                            </div>
                                            <div class="mb-3">
                                                <label for="editdescription' . $driver->id . '" class="form-label">Description</label>
                                                <input type="text" value="' . $driver->description . '" class="form-control" id="editdescription' . $driver->id . '" aria-describedby="emailHelp"> 
                                            </div> 
                                            <div class="mb-1">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="editstatus' . $driver->id . '" class="form-control" required>
                                                    <option ' . ($driver->status == "pending" ? "selected" : "") . ' value="pending">Pending</option>
                                                    <option ' . ($driver->status == "active" ? "selected" : "") . ' value="active">Active</option>
                                                    <option ' . ($driver->status == "inactive" ? "selected" : "") . ' value="inactive">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="editSaveBtn" data-id="' . $driver->id . '">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </td>
                    </tr>';
        }

        return $html;
    }

    public function mechanics()
    {
        $html = $this->generateDriverRowsHtml();

        return response()->json([
            'html' => $html,
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
            'email' => 'nullable|email',
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

