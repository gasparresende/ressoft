<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermissionsUserController extends Controller
{
    public function index()
    {
        return view('permissions_users.index');
    }
}
