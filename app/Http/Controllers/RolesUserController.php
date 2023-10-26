<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RolesUserController extends Controller
{
    public function index()
    {
        return view('roles_users.index');
    }
}
