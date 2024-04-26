<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TripDestinationController extends Controller
{
    public function index(){

        return view('tripdestination.index');
    }
    public function getDirections(Request $request)
    {
        $startPoint = urlencode($request->startPoint);
        $endPoint = urlencode($request->endPoint);
        $apiKey = 'YOUR_GOOGLE_MAPS_API_KEY';

        $response = Http::get("https://maps.googleapis.com/maps/api/directions/json?origin=$startPoint&destination=$endPoint&key=$apiKey");
        
        return $response->json();
    }
}

