<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermissionsRoleController extends Controller
{
    public function index()
    {
        return view('permissions_roles.index');
    }
}
