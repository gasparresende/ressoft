<?php

namespace App\Http\Controllers;

use App\Models\user;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param \App\Models\User $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        return view('users.index');
    }

    public function store(UserRequest $request)
    {

        if ($request->password != "") {
            $dados = [
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ];
        } else {
            $dados = [
                'username' => $request->username,
                'email' => $request->email,
            ];
        }

        $inserir = DB::table('users')->updateOrInsert(['id' => $request->id], $dados);

        if ($inserir)
            return back()->with("sucesso", "Dados Salvo com sucesso!");
        else
            return back()->with("erro", "Erro ao Salvar");
    }

    public function reset(UserRequest $request)
    {

        $dados = [
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ];

        $reset = DB::table('users')->where('id', $request->id)->update($dados);

        if ($reset)
            return back()->with("sucesso", "Password Alterada com sucesso!");
        else
            return back()->with("erro", "Erro ao Alterar Password");
    }

    public function show(Request $request)
    {
        echo json_encode(DB::table('users')->where('id', $request->id)
            ->get());
    }

    public function delete(Request $request)
    {

        if (DB::table('users')->where('id', $request->id)->delete()) {
            DB::statement("ALTER TABLE users AUTO_INCREMENT =  $request->id");
            return redirect()->back()->with('sucesso', 'Dados eliminado com sucesso!!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao eliminar');
        }
    }

    public function listar()
    {
        $users = DB::table('users')
            ->where('status', 1)
            ->select([
                '*',
            ]);


        return DataTables::of($users)
            ->make(true);
    }

    public function update_image(Request $request)
    {

        $user = User::all()->find(auth()->id());
        if (!isset($request->foto_perfil))
            return redirect()->back()->with('erro', 'Não foi carregada a Imagem');

        $dir = 'users/' . auth()->id();
        Storage::deleteDirectory($dir);
        $upload = $request->file('foto_perfil')->store($dir);

        $user->update(['foto_perfil' => $upload]);
        return redirect()->back()->with('sucesso', 'Imagem Alterada com sucesso!');


    }

}
