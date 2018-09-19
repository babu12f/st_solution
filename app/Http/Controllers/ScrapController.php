<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScrapController extends Controller
{
    public function index(Request $request)
    {
        return $request->all();
    }
    
    public function koli(Request $request)
    {
        return view('koli');
    }
}
