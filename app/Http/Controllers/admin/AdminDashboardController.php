<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(){
        // admin dashboard
        $contacts = Contact::get();
        return view('contacts.index', compact('contacts'));
    }
    public function userdashboard(){
        // user dashboard
        $contacts = Contact::get();
        return view('dashboard.user.user', compact('contacts'));
    }
}
