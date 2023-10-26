<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BalanceteController extends Controller
{
    public function index()
    {
        return view('balancetes.index');
    }
}
