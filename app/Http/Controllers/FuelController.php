<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FuelController extends Controller
{
    public function index() {
        return view('fuel.index');
    }
}
