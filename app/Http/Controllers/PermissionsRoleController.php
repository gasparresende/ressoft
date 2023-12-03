<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class PermissionsRoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('permissions_roles.index', [
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }


    public function create()
    {
        if (Gate::denies('new'))
            return redirect()->back()->with('erro', 'Não Tens Permissão para Cadastrar');

        $roles = Role::all();
        $permissions = Permission::all();
        return view('permissions_roles.create', [
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }


    public function store(Request $request)
    {

        $role = Role::all()->find($request->roles_id);
        foreach ($request->permission_id as $dado) {
            $permission = Permission::all()->find($dado);

            $role->givePermissionTo($permission); //Atribuir permissao a Role
        }


        return redirect()->route('permissions_roles.index')->with('sucesso', 'Role salva com sucesso!');

    }


    public function show($id)
    {
        if (Gate::denies('view'))
            return redirect()->back()->with('erro', 'Não Tens Permissão para vizualizar este Item');

        $permissions_roles = PermissionRole::all()->where('id', $id);
        $roles = Role::all();
        $permissions = Permission::all();
        return view('permissions_roles.show', [
            'permissions_roles' => $permissions_roles,
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }


    public function edit($id)
    {
        if (Gate::denies('update'))
            return redirect()->back()->with('erro', 'Não Tens Permissão para alterar este Item');

        $permissions_roles = PermissionRole::all()->where('id', $id);
        $roles = Role::all();
        $permissions = Permission::all();
        return view('permissions_roles.edit', [
            'permissions_roles' => $permissions_roles,
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }


    public function update(Request $request, $id)
    {
        $dados = [
            'permission_id' => $request->permission_id,
            'role_id' => $request->role_id,
        ];
        if (PermissionRole::all()->find($id)->update($dados))
            return redirect()->route('permissions_roles.index')->with('sucesso', 'Dados Alterado com sucesso!!');
        else
            return redirect()->back()->with('erro', 'Erro ao alterar');
    }


    public function destroy($id)
    {
        if (Gate::denies('delete'))
            return redirect()->back()->with('erro', 'Não Tens Permissão para eliminar este Item');

        PermissionRole::destroy($id);
        return redirect()->route('permissions_roles.index')->with('sucesso', 'Dados Removido com sucesso!!');
    }

    public function listar_by_id(Request $request)
    {

        $roles_users = DB::table('role_has_permissions')->where('role_id', $request->id)
            ->get();
        $permission_id = [];
        foreach ($roles_users as $roles_user) {
            array_push($permission_id, $roles_user->permission_id);
        }
        $permission = DB::table('permissions')->whereNotIn('id', $permission_id)
            ->get();

        echo json_encode($permission);
    }


    public function delete(Request $request)
    {
        //$role_permission = RoleHasPermission::all()->find($request->id);
        $role = Role::all()->find($request->role_id);
        $permission = Permission::all()->find($request->permission_id);

        //$permission->removeRole($role);
        if ($role->revokePermissionTo($permission)) {

            return redirect()->back()->with('sucesso', 'Dados eliminado com sucesso!!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao eliminar');
        }
    }

    public function listar()
    {
        $roles = DB::table('role_has_permissions')
            ->join('permissions', 'permissions.id', 'role_has_permissions.permission_id')
            ->join('roles', 'roles.id', 'role_has_permissions.role_id')
            ->select([
                '*',
                'permissions.name as permissao',
                'roles.name as funcao',
            ]);


        return DataTables::of($roles)
            ->make(true);
    }
}
