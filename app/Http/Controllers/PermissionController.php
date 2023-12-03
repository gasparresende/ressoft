<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    public function index()
    {
        return view('permissions.index');
    }


    public function store(Request $request)
    {

        if (isset($request->id)) {
            $permission = Permission::all()->find($request->id);
            $permission->update([
                'name' => $request->name
            ]);

            return redirect()->route('permissions.index')->with('sucesso', 'Permission Alterada com sucesso!');


        } else {
            $dados = explode(';', str_replace(' ', '', $request->name));

            foreach ($dados as $dado) {
                $permission = Permission::all()->where('name', $dado);

                if ($permission->isEmpty()) {
                    Permission::create(['name' => $dado]);
                }
            }

            return redirect()->route('permissions.index')->with('sucesso', 'Permission salva com sucesso!');
        }

    }


    public function show(Request $request)
    {
        echo json_encode(DB::table('permissions')->where('id', $request->id)
            ->get());
    }




    public function delete(Request $request)
    {

        if (Permission::all()->find($request->id)->delete()) {
            DB::statement("ALTER TABLE permissions AUTO_INCREMENT =  $request->id");
            return redirect()->back()->with('sucesso', 'Dados eliminado com sucesso!!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao eliminar');
        }
    }

    public function listar()
    {
        $permissions = DB::table('permissions')
            ->select([
                '*',
            ]);


        return DataTables::of($permissions)
            ->make(true);
    }

}
