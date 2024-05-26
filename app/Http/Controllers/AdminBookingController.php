<?php

namespace App\Http\Controllers;

use App\Models\requestVehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\PDF;

class AdminBookingController extends Controller
{
    public function index()
    {  
        $requests = requestVehicle::where('status', 'pending')->orderBy('created_at', 'desc')->get();
        return view('pending_requests\pending-request-vehicles', compact('requests'));
    }
    public function accepted()
    {  
        $requests = requestVehicle::where('status', 'accept')->orderBy('created_at', 'desc')->get();
        return view('pending_requests\accept-request-vehicles', compact('requests'));
    }
    public function declined()
    {  
        $requests = requestVehicle::where('status', 'decline')->orderBy('created_at', 'desc')->get();
        return view('pending_requests\decline-request-vehicles', compact('requests'));
    }

    public function updateStatus($id, $status)
    {
        if ($status === 'accept') {
            requestVehicle::findOrFail($id)->update([
                'status' => 'accept'
            ]);
        } elseif ($status === 'decline') {
            requestVehicle::findOrFail($id)->update([
                'status' => 'decline'
            ]); 
        } elseif ($status === 'pending') {
            requestVehicle::findOrFail($id)->update([
                'status' => 'pending'
            ]);
        }


        return back();
    }

    public function printPdfById($id){
        
        $acceptedRequest = requestvehicle::findOrFail($id);
    
    
        // Load the view for the individual accepted request
        $pdf = PDF::loadView('request_accepted_vehicle_pdf', compact('acceptedRequest'));

        // Generate and stream the PDF
        return $pdf->stream('accepted_request_' . $id . '.pdf');
    }
    

}
