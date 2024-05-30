<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function index()
    {
        if(Auth::user()->hasRole('admin'))
        {
            return redirect()->route('admin-dashboard');
        }elseif(Auth::user()->hasRole('landlord'))
        {
            return redirect()->route('landlord-dashboard');
        }elseif(Auth::user()->hasRole('student'))
        {
            return redirect()->route('student-dashboard');
        }
    }
}
