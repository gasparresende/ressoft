<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        return view('roles.index');
    }


    public function store(Request $request)
    {

        if (isset($request->id)) {
            $role = Role::all()->find($request->id);
            $role->update([
                'name' => $request->name
            ]);

            return redirect()->route('roles.index')->with('sucesso', 'Role Alterada com sucesso!');


        } else {
            $dados = explode(';', str_replace(' ', '', $request->name));

            foreach ($dados as $dado) {
                $role = Role::all()->where('name', $dado);

                if ($role->isEmpty()) {
                    Role::create(['name' => $dado]);
                }
            }

            return redirect()->route('roles.index')->with('sucesso', 'Role salva com sucesso!');
        }

    }


    public function show(Request $request)
    {
        echo json_encode(DB::table('roles')->where('id', $request->id)
            ->get());
    }



    public function destroy($id)
    {
    }

    public function delete(Request $request)
    {

        if (Role::all()->find($request->id)->delete()) {
            DB::statement("ALTER TABLE roles AUTO_INCREMENT =  $request->id");
            return redirect()->back()->with('sucesso', 'Dados eliminado com sucesso!!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao eliminar');
        }
    }

    public function listar()
    {
        $roles = DB::table('roles')
            ->select([
                '*',
            ]);


        return DataTables::of($roles)
            ->make(true);
    }


}
