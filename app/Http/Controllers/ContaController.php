<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContaController extends Controller
{
    public function index()
    {
        return view('contas.index');
    }

}
