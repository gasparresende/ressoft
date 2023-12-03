<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleUserController extends Controller
{

    public function index()
    {
        $user = User::all();
        return view('roles_users.index', [
            'users' => $user
        ]);
    }

    public function store(Request $request)
    {
        $user = User::all()->find($request->users_id);
        foreach ($request->roles_id as $dado) {
            $role = Role::all()->find($dado);

            $user->assignRole($role->name);
        }


        return redirect()->route('roles_users.index')->with('sucesso', 'Role salva com sucesso!');
    }

    public function show()
    {

    }

    public function listar_by_id(Request $request)
    {
        $role = Role::all()->find($request->id);

        $roles_users = DB::table('model_has_roles')->where('model_id', $request->id)
            ->get();
        $roles_id = [];
        foreach ($roles_users as $roles_user) {
            array_push($roles_id, $roles_user->role_id);
        }
        $roles = DB::table('roles')->whereNotIn('id', $roles_id)
            ->get();

        echo json_encode($roles);
    }


    public function delete(Request $request)
    {

        $role = Role::all()->find($request->role_id);
        $user = User::all()->find($request->model_id);

        $user->removeRole($role->name);
        return redirect()->back()->with('sucesso', 'Dados eliminado com sucesso!!');

    }

    public function listar()
    {
        $roles = DB::table('model_has_roles')
            ->join('users', 'users.id', 'model_has_roles.model_id')
            ->join('roles', 'roles.id', 'model_has_roles.role_id')
            ->select([
                '*',
            ]);


        return DataTables::of($roles)
            ->make(true);
    }
}
