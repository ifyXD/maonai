<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\User; // Assuming your User model is in the App\Models namespace
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserContactController extends Controller
{


    /**
     * Display all users data in the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all users
        $users = User::all();

        // Pass users data to the view
        return view('user.index', compact('users'));
    }

     /**
     * Display the form for creating a new contact for a specific user.
     *
     * @param  int  $userId
     * @return \Illuminate\View\View
     */
    public function create($userId)
    {
        $user = User::findOrFail($userId);

        return view('contacts.create', compact('user'));
    }

    /**
     * Insert a new contact record associated with a specific user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function insert(Request $request, $userId)
    {
        try {
            // Validate request data
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email', // Removed the unique constraint
                'department' => 'required|string|max:255',
                'request_type' => 'required|array',
                'request_type.*' => 'in:Maintenance,Service,Commission,Construction,Transportation',
                'content' => 'nullable|string|max:500',
            ]);


             // Combine request type and content
                $combinedContent = implode(', ', $request->request_type);
                if ($request->filled('content')) {
                    $combinedContent .= ' - ' . $request->input('content');
                }

            // Create new contact
            $contact = new Contact();
            $contact->user_id = $userId;
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->department = $request->department;
            $contact->content = $combinedContent; // Assign combined content
            $contact->status = 'pending'; // Set status to 'pending'
            $contact->save();

            // Flash success message
            return redirect()->route('contacts.create', ['userId' => $userId])->with('success', 'Contact created successfully.');
        } catch (ValidationException $e) {
            // Validation errors
            return redirect()->back()->withInput()->withErrors($e->validator->errors());
        }


    }

    /**
 * Display the form for creating a new contact for the currently logged-in user.
 *
 * @return \Illuminate\View\View
 */
public function createForCurrentUser()
{
    $user = auth()->user();
    return view('contacts.createNew', compact('user'));
}

/**
 * Insert a new contact record associated with the currently logged-in user.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function insertForCurrentUser(Request $request)
{
    try {
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email', // Removed the unique constraint
            'department' => 'required|string|max:255',
            'request_type' => 'required|array',
            'request_type.*' => 'in:Maintenance,Service,Commission,Construction,Transportation',
            'content' => 'nullable|string|max:500',
        ]);

        // Get the currently logged-in user
        $user = auth()->user();

        // Combine request type and content
        $combinedContent = implode(', ', $request->request_type);
        if ($request->filled('content')) {
            $combinedContent .= ' - ' . $request->input('content');
        }

        // Create new contact
        $contact = new Contact();
        $contact->user_id = $user->id;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->department = $request->department;
        $contact->content = $combinedContent; // Assign combined content
        $contact->status = 'pending'; // Set status to 'pending'
        $contact->save();

        // Flash success message
        return redirect()->route('contacts.createNew')->with('success', 'Contact created successfully.');
    } catch (ValidationException $e) {
        // Validation errors
        return redirect()->back()->withInput()->withErrors($e->validator->errors());
    }
}




        public function showUserContacts()
    {
        $user = Auth::user();
        $contacts = $user->contacts; // Assuming a one-to-many relationship is defined in the User model

        return view('user.user', compact('user', 'contacts'));
    }



}
