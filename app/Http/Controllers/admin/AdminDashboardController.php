<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(){
        return view('dashboard.admin.useradmin');
    }
    public function userdashboard(){
        return view('dashboard.user.user');
    }
}
