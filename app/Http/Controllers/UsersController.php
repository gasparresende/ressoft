<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{

    public function login(Request $request)
    {
        if (Auth::attempt($request->only('username', 'password'))){
            return redirect()->route('home');
        }
        else{
            echo "erro";
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('inicio');
    }

    public function home()
    {
        return view('home');
    }

    public function listar_by_loja(Request $request)
    {

    }
}
