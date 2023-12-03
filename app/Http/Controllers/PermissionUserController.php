<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $permissions = Permission::all();

        return view('permission_users.index', [
            'users' => $users,
            'permissions' => $permissions,
        ]);
    }


    public function store(Request $request)
    {

        $user = User::all()->find($request->users_id);
        foreach ($request->permission_id as $dado) {
            $permission = Permission::all()->find($dado);

            $user->givePermissionTo($permission); //Atribuir permissao a Users
        }


        return redirect()->route('permission_users.index')->with('sucesso', 'Permissão atribuida com sucesso!');

    }


    public function listar_by_id(Request $request)
    {

        $users_users = DB::table('model_has_permissions')->where('model_id', $request->id)
            ->get();
        $permission_id = [];
        foreach ($users_users as $users_user) {
            array_push($permission_id, $users_user->permission_id);
        }
        $permission = DB::table('permissions')->whereNotIn('id', $permission_id)
            ->get();

        echo json_encode($permission);
    }


    public function delete(Request $request)
    {
        $user = User::all()->find($request->model_id);
        $permission = Permission::all()->find($request->permission_id);

        $user->revokePermissionTo($permission->name);

        return redirect()->back()->with('sucesso', 'Dados eliminado com sucesso!!');

    }

    public function listar()
    {
        $users = DB::table('model_has_permissions')
            ->join('permissions', 'permissions.id', 'model_has_permissions.permission_id')
            ->join('users', 'users.id', 'model_has_permissions.model_id')
            ->select([
                '*',
                'permissions.name as permissao',
            ]);


        return DataTables::of($users)
            ->make(true);
    }
}
