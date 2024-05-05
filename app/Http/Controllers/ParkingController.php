<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ParkingController extends Controller
{
    public function index()
    {
        $data = [
            ['title' => 'Card 1', 'content' => 'This is the content of card 1'],
            ['title' => 'Card 2', 'content' => 'This is the content of card 2'],
            ['title' => 'Card 3', 'content' => 'This is the content of card 3'],
        ];
    
        return view('parking.index', compact('data'));
    }
}