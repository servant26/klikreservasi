<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffController extends Controller
{
    // Display the staff dashboard
    public function index()
    {
        return view('dashboard.staff'); // Assuming you have this view
    }
}
