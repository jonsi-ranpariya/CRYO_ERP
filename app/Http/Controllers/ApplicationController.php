<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\User;
use App\Http\Controllers\Controller;

class ApplicationController extends Controller
{
    public function index()
    {
        return view('application');
    }
}
