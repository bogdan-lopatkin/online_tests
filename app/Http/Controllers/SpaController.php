<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpaController extends Controller
{
    public function index($url = null)
    {
        return view('spa',compact('url'));
    }
}
