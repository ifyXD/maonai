<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TripDestinationController extends Controller
{
    public function index(){

        return view('tripdestination.index');
    }
    public function create(Request $request)
    {
    
    }
}

