<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Request as RequestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Import Log facade
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Validator;

class ContactRequestController extends Controller
{


public function getContactRequests()
{
    try {
        // Call the stored procedure to get contact requests
        $requests = DB::select('CALL GetContactRequests()');

        // Count data associated with each contact's requests
        $counts = [
            'total' => count($requests),
            'pending' => 0,
            'accepted' => 0,
            'declined' => 0,
        ];

        foreach ($requests as $request) {
            switch ($request->status) {
                case 'pending':
                    $counts['pending']++;
                    break;
                case 'accepted':
                    $counts['accepted']++;
                    break;
                case 'declined':
                    $counts['declined']++;
                    break;
            }
        }

        // Return the data and counts to the view
        return view('dashboard.admin.useradmin', compact('requests', 'counts'));
    } catch (\Exception $e) {
        // Handle any errors
        return redirect()->back()->with('error', 'An error occurred while fetching contact requests.');
    }
}

public function showPendingRequests()
{
    try {
        // Fetch requests with "pending" status from the database
        $pendingRequests = RequestModel::where('status', 'pending')->get();

        // Count data associated with pending requests
        $counts = [
            'total' => count($pendingRequests),
            'pending' => count($pendingRequests),
            'accepted' => 0,
            'declined' => 0,
        ];

        // Return the data and counts to the view
        return view('pending_requests.index', compact('pendingRequests', 'counts'));
    } catch (\Exception $e) {
        // Handle any errors
        Log::error('Error fetching pending requests: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while fetching pending requests.');
    }
}

public function showAcceptedRequests()
{
    try {
        // Fetch requests with "accepted" status from the database
        $acceptedRequests = RequestModel::where('status', 'accepted')->get();

        // Count data associated with accepted requests
        $counts = [
            'total' => count($acceptedRequests),
            'pending' => 0,
            'accepted' => count($acceptedRequests),
            'declined' => 0,
        ];

        // Return the data and counts to the view
        return view('accepted_requests.index', compact('acceptedRequests', 'counts'));
    } catch (\Exception $e) {
        // Handle any errors
        return redirect()->back()->with('error', 'An error occurred while fetching accepted requests.');
    }
}

public function showDeclinedRequests()
{
    try {
        // Fetch requests with "declined" status from the database
        $declinedRequests = RequestModel::where('status', 'declined')->get();

        // Count data associated with declined requests
        $counts = [
            'total' => count($declinedRequests),
            'pending' => 0,
            'accepted' => 0,
            'declined' => count($declinedRequests),
        ];

        // Return the data and counts to the view
        return view('declined_requests.index', compact('declinedRequests', 'counts'));
    } catch (\Exception $e) {
        // Handle any errors
        Log::error('Error fetching declined requests: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while fetching declined requests.');
    }
}

    public function create()
    {
        return view('welcome');
    }


    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'contact_name' => 'required|string',
            'contact_email' => 'required|email|unique:contacts,email',
            'content' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'labor_needed' => 'required|string',
        ]);

        try {
            // Call the stored procedure to insert data into contacts and requests tables
            $contactId = DB::selectOne('CALL InsertContactAndRequest(?, ?, ?, ?, ?, ?)', [
                $request->contact_name,
                $request->contact_email,
                $request->content,
                $request->quantity,
                $request->unit_cost,
                $request->labor_needed,
            ]);

            // Retrieve the newly inserted contact
            $contact = Contact::findOrFail($contactId->contact_id);

            // Prepare the data to be stored in JSON format
            $data = [
                'contact' => $contact,
                'request' => [
                    'content' => $request->content,
                    'quantity' => $request->quantity,
                    'unit_cost' => $request->unit_cost,
                    'total_cost' => $request->quantity * $request->unit_cost,
                    'labor_needed' => $request->labor_needed,
                ],
            ];

            // Convert data to JSON format
            $jsonData = json_encode($data);

            // Generate a unique filename
            $filename = 'individual_data_' . $contactId->contact_id . '.json';

            // Save JSON data to a unique file in the public path
            $filePath = public_path($filename);
            File::put($filePath, $jsonData);

            // Flash success message to the session
            return redirect()->route('welcome')->with('success', 'Inserted successfully. Contact ID: ' . $contactId->contact_id);
        } catch (\Exception $e) {
            // Handle any errors that occur during the insertion process
            return redirect()->back()->with('error', 'An error occurred while inserting data.');
        }
    }


    public function updateStatus(Request $request)
    {
        try {
            $request->validate([
                'requestId' => 'required|exists:requests,id',
                'status' => 'required|in:pending,accepted,declined',
            ]);

            // Find the request by ID
            $requestModel = RequestModel::findOrFail($request->requestId);

            // Get the current status
            $currentStatus = $requestModel->status;

            // Update the status in the database
            $requestModel->status = $request->status;
            $requestModel->save();

            // If status is accepted, delete the JSON file
            if ($request->status === 'accepted') {
                $filename = 'individual_data_' . $request->requestId . '.json';
                $filePath = public_path($filename);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // If status is pending and was previously accepted, convert data to JSON format
            if ($request->status === 'pending' && $currentStatus === 'accepted') {
                // Retrieve the data associated with the request
                $requestData = [
                    'contact' => $requestModel->contact,
                    'request' => [
                        'content' => $requestModel->content,
                        'quantity' => $requestModel->quantity,
                        'unit_cost' => $requestModel->unit_cost,
                        'total_cost' => $requestModel->quantity * $requestModel->unit_cost,
                        'labor_needed' => $requestModel->labor_needed,
                    ],
                ];

                // Convert data to JSON format
                $jsonData = json_encode($requestData);

                // Generate a unique filename
                $filename = 'individual_data_' . $request->requestId . '.json';

                // Save JSON data to a unique file in the public path
                $filePath = public_path($filename);
                File::put($filePath, $jsonData);
            }

            // Log the status update
            Log::info('Status updated successfully for request ID: ' . $request->requestId . ', New status: ' . $request->status);

            return redirect()->back()->with('success', 'Status updated successfully');
        } catch (\Exception $e) {
            // Log any errors
            Log::error('Error updating status: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating status');
        }
    }


public function getDataCounts()
{
    try {
        // Get counts for each status from the database
        $counts = [
            'accepted' => RequestModel::where('status', 'accepted')->count(),
            'pending' => RequestModel::where('status', 'pending')->count(),
            'declined' => RequestModel::where('status', 'declined')->count(),
        ];

        // Return the counts
        return $counts;
    } catch (\Exception $e) {
        // Log any errors
        Log::error('Error fetching data counts: ' . $e->getMessage());
        return null;
    }
}

public function showDataCounts()
{
    try {
        // Get counts for each status
        $counts = $this->getDataCounts();

        // Render the view and pass counts data to it
        return view('data_counts', compact('counts'));
    } catch (\Exception $e) {
        // Log any errors
        Log::error('Error rendering data counts view: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while fetching data counts');
    }
}

public function exportAcceptedRequestsPDF()
{
    try {
        $acceptedRequests = RequestModel::where('status', 'accepted')->get();

        $pdf = PDF::loadView('accepted_requests_pdf', compact('acceptedRequests'));

        return $pdf->download('accepted_requests.pdf');
    } catch (\Exception $e) {
        // Handle any errors
    }
}

public function exportIndividualAcceptedRequestPDF($requestId)
{
    try {
        // Find the accepted request by ID
        $acceptedRequest = RequestModel::findOrFail($requestId);


        // Load the view for the individual accepted request
        $pdf = PDF::loadView('individual_accepted_request_pdf', compact('acceptedRequest'));

        // Generate and stream the PDF
        return $pdf->stream('accepted_request_' . $requestId . '.pdf');
    } catch (\Exception $e) {
        // Handle any errors
    }
}


public function editRequest($id)
{
    try {
        // Find the request by ID
        $request = RequestModel::findOrFail($id);

        // Return the view for editing the request with the found request data
        return view('edit_request', compact('request'));
    } catch (\Exception $e) {
        // Handle any errors
    }
}

public function updateRequest(Request $request, $id)
{
    // Validate the incoming request data if needed

    try {
        // Find the request by ID
        $requestModel = RequestModel::findOrFail($id);

        // Update the request data
        $requestModel->update([
            'content' => $request->content,
            'quantity' => $request->quantity,
            'unit_cost' => $request->unit_cost,
            'labor_needed' => $request->labor_needed,
            // Add more fields as needed
        ]);

        // Redirect to the contacts_requests.index route upon successful update
        return redirect()->route('contacts_requests')->with('success', 'Request updated successfully');
    } catch (\Exception $e) {
        // Handle any errors
        return redirect()->back()->with('error', 'An error occurred while updating the request');
    }
}

// Other methods...

public function edit($id)
{
    try {
        // Find the request by ID
        $request = RequestModel::findOrFail($id);

        // Return the view for editing the request with the found request data
        return view('edit_request', compact('request'));
    } catch (\Exception $e) {
        // Handle any errors
        Log::error('Error editing request: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while editing the request.');
    }
}

public function update(Request $request, $id)
{
    // Validate the incoming request data if needed

    try {
        // Find the request by ID
        $requestModel = RequestModel::findOrFail($id);

        // Update the request data
        $requestModel->update([
            'content' => $request->content,
            'quantity' => $request->quantity,
            'unit_cost' => $request->unit_cost,
            'labor_needed' => $request->labor_needed,
            // Add more fields as needed
        ]);

        // Redirect to the contacts_requests.index route upon successful update
        return redirect()->route('accepted_requests')->with('success', 'Request updated successfully');
    } catch (\Exception $e) {
        // Handle any errors
        Log::error('Error updating request: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while updating the request');
    }
}


}
