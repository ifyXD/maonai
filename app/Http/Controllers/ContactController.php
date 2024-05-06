<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Display a listing of the contacts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::all();
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new contact.
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created contact in storage.
     */
    /**
     * Store a newly created contact in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:contacts,email',
            'department' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        // Create new contact
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->department = $request->department;
        $contact->content = $request->content;
        $contact->save();

        // Return JSON response
        return response()->json([
            'success' => true,
            'message' => 'Contact created successfully.',
            'contact' => $contact,
        ]);
    }

    // /**
    //  * Update the specified contact in the database.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'name' => 'required|string',
    //         'email' => 'required|email|unique:contacts,email,' . $id,
    //         'department' => 'required|string',
    //         'content' => 'nullable|string', // Add validation for the content field
    //         // Add validation for other fields as needed
    //     ]);

    //     $contact = Contact::findOrFail($id);
    //     $contact->update($request->all());

    //     return redirect()->route('contacts.index')
    //         ->with('success', 'Contact updated successfully.');
    // }

     /**
     * Update the specified contact in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:contacts,email,' . $id,
            'department' => 'required|string',
            'content' => 'nullable|string', // Add validation for the content field
            // Add validation for other fields as needed
        ]);

        $contact = Contact::findOrFail($id);
        $contact->update($request->all());

        // Return the updated contact data in JSON format
        return response()->json($contact);
    }
}
