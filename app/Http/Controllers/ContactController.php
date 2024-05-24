<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class ContactController extends Controller
{




    /**
     * Show the form for creating a new contact.
     */
    public function create()
    {
        return view('welcome');
    }

    /**
 * Store a newly created contact in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\JsonResponse
 */
public function store(Request $request)
{
    try {
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:contacts,email',
            'department' => 'required|string|max:255',
            'request_type' => 'required|array',
            'request_type.*' => 'in:repair,service,commission',
            'other' => 'nullable|string|max:500',
        ]);

        // Create new contact
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->department = $request->department;
        $contact->content = implode(', ', $request->request_type); // Combine selected request types
        if ($request->has('other')) {
            $contact->content .= ' - : ' . $request->other; // Add 'other' field if provided
        }
        $contact->status = 'pending'; // Set status to 'pending'
        $contact->save();

        // Flash success message
        return redirect()->route('welcome')->with('success', 'Contact created successfully.');
    } catch (ValidationException $e) {
        // Email already exists
        if ($e->validator->errors()->has('email')) {
            return redirect()->back()->withInput()->withErrors(['email' => 'The email has already been taken.']);
        }
        // For other validation errors
        throw $e;
    }
}

/**
 * Update the status of the specified contact.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $contact_id
 * @return \Illuminate\Http\Response
 */
public function updateStatus(Request $request, $contact_id)
{
    // Validate request data
    $request->validate([
        'status' => 'required|in:pending,accepted,declined',
    ]);

    // Find the contact by ID
    $contact = Contact::findOrFail($contact_id);

    // Get the current status
    $currentStatus = $contact->status;

    // Update the status
    $contact->status = $request->status;
    $contact->save();

    // If status is pending and was previously accepted, convert data to JSON format
    if ($request->status === 'pending' && $currentStatus === 'accepted') {
        // Retrieve the data associated with the request
        $requestData = [
            // Include your data here
        ];

        // Convert data to JSON format
        $jsonData = json_encode($requestData);

        // Generate a unique filename
        $filename = 'pendingData_' . $contact_id . '.json';

        // Save JSON data to a unique file in the public path
        $filePath = public_path($filename);
        File::put($filePath, $jsonData);
    }

    // If status is accepted and was previously pending, remove JSON file and update data
    if ($request->status === 'accepted' && $currentStatus === 'pending') {
        // Generate the filename
        $filename = 'pendingData_' . $contact_id . '.json';

        // Check if the file exists and delete it
        if (File::exists(public_path($filename))) {
            File::delete(public_path($filename));
        }

        // Update the data accordingly
        // Your code to update the data...
    }

    // Redirect back with success message
    return redirect()->back()->with('status', 'Contact status updated successfully.');
}




/**
 * Display a listing of the contacts.
 *
 * @return \Illuminate\Http\Response
 */
public function index()
{
    $contacts = Contact::all();
    $counts = $this->getCounts(); // Call getCounts() method
    return view('contacts.index', compact('contacts', 'counts'));
}

/**
     * Display the accepted contacts.
     *
     * @return \Illuminate\Http\Response
     */
    public function accepted()
{
    // Paginate contacts with status 'accepted'
    $contacts = DB::table('contacts')->where('status', 'accepted')->paginate(10);

    $counts = $this->getCounts();

    // Return the view with the paginated contacts data
    return view('contacts.accept', compact('contacts', 'counts'));
}



/**
 * Display the contacts with pending status.
 *
 * @return \Illuminate\Http\Response
 */
public function pending()
{
    // Paginate contacts with status 'pending'
    $contacts = DB::table('contacts')->where('status', 'pending')->paginate(10);

    // Get contact counts
    $counts = $this->getCounts();

    return view('contacts.pending', compact('contacts', 'counts'));
}

/**
 * Display the declined contacts.
 *
 * @return \Illuminate\Http\Response
 */
public function declined()
{
    // Retrieve declined contacts from the database
    $contacts = DB::table('contacts')->where('status', 'declined')->paginate(10);

    // Get contact counts
    $counts = $this->getCounts();

    return view('contacts.declined', compact('contacts', 'counts'));
}

/**
 * Count the number of contacts based on their status.
 *
 * @return array
 */
public function getCounts()
{
    // Count overall total contacts
    $totalContacts = Contact::count();

    // Count contacts based on status
    $acceptedCount = Contact::where('status', 'accepted')->count();
    $pendingCount = Contact::where('status', 'pending')->count();
    $declinedCount = Contact::where('status', 'declined')->count();

    // Return the counts data to the views
    return [
        'totalContacts' => $totalContacts,
        'acceptedCount' => $acceptedCount,
        'pendingCount' => $pendingCount,
        'declinedCount' => $declinedCount,
    ];
}

 /**
     * Show the form for editing the specified contact.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Fetch the contact with the given ID and pass it to the view
        $contact = Contact::findOrFail($id);
        return view('contacts.edit', compact('contact'));
    }



 /**
 * Update the specified contact in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\RedirectResponse
 */
public function update(Request $request, $id)
{
    // Validate request data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:contacts,email,'.$id,
        'department' => 'required|string|max:255',
        'request_type' => 'required|array',
        'request_type.*' => 'in:repair,service,commission',
        'other' => 'nullable|string|max:500',
    ]);

    // Find the contact by ID
    $contact = Contact::findOrFail($id);

    // Update contact data
    $contact->name = $request->name;
    $contact->email = $request->email;
    $contact->department = $request->department;
    $contact->content = implode(', ', $request->request_type); // Combine selected request types
    if ($request->has('other')) {
        $contact->content .= ' - : ' . $request->other; // Add 'other' field if provided
    }
    $contact->save();

    // Debugging: Check if the redirect_to parameter is present and its value
    Log::info('Redirect to parameter: ', ['redirect_to' => $request->get('redirect_to')]);

    // Conditional redirect based on a query parameter
    if ($request->has('redirect_to') && $request->redirect_to == 'accept') {
        Log::info('Redirecting to contacts.accept');
        return redirect()->route('contacts.accept')->with('success', 'Contact updated successfully.');
    }


    // Debugging: Default redirect
    Log::info('Redirecting to contacts.index');
    return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');
}

}
