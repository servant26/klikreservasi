<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // Display the user dashboard
    public function index()
    {
        return view('user.dashboard'); // Assuming you have this view
    }
}
