<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        // No need to return the users tasks and can get this directly in the blade file from the user class.
        return view('dashboard');
    }
}
