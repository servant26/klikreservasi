<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffController extends Controller
{
    // Display the staff dashboard
    public function index()
    {
        return view('staff.dashboard'); // Assuming you have this view
    }

    public function tambah()
    {
        return view('staff.tambah'); // Assuming you have this view
    }
}
