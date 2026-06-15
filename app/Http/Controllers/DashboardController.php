<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $clubs = $request->user()->clubs()->get();

        return view('dashboard', compact('clubs'));
    }
}