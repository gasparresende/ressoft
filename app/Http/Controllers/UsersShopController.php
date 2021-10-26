<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use App\Models\UsersShop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users_shops = UsersShop::all();
        // $users_shops = UsersShop::all()->sortByDesc('id');
        return view('users_shops.index', [
            'users_shops' => $users_shops
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //if (Gate::denies('new'))
        //  return redirect()->back()->with('erro', 'Não Tens Permissão para Cadastrar');

        $users_shops = UsersShop::all();
        $shops = Shop::all();
        //$users = User::all()->whereNotIn('id', paraArray($users_shops, 'users_id'));
        $users = User::all();

        return view('users_shops.create', [
            'shops' => $shops,
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->users_id as $item) {
            UsersShop::create([
                'users_id'=>$item,
                'shops_id'=>$request->shops_id,
            ]);
        }
        return redirect()->route('users_shops.index')->with('sucesso', 'Dados Salvo com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\UsersShop $users_shop
     * @return \Illuminate\Http\Response
     */
    public function show(UsersShop $shop)
    {
        //if (Gate::denies('view'))
        // return redirect()->back()->with('erro', 'Não Tens Permissão para vizualizar este Item');

        return view('users_shops.show', [
            'shop' => $shop
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\UsersShop $users_shop
     * @return \Illuminate\Http\Response
     */
    public function edit(UsersShop $users_shop)
    {
        //if (Gate::denies('update'))
        // return redirect()->back()->with('erro', 'Não Tens Permissão para alterar este Item');

        $shops = Shop::all();
        //$users = User::all()->whereNotIn('id', paraArray($users_shops, 'users_id'));
        $users = User::all();

        return view('users_shops.edit', [
            'shops' => $shops,
            'users' => $users,
            'users_shop' => $users_shop,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UsersShop $users_shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UsersShop $users_shop)
    {
        if ($users_shop->update($request->all())) {
            return redirect()->route('users_shops.index')->with('sucesso', 'Dados Alterado com sucesso!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao Alterar');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\UsersShop $users_shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(UsersShop $users_shop)
    {
        //if (Gate::denies('delete'))
        // return redirect()->back()->with('erro', 'Não Tens Permissão para eliminar este Item');

        if ($users_shop->delete()) {
            return redirect()->route('users_shops.index')->with('sucesso', 'Dados Eliminado com sucesso!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao Eliminar');
        }
    }
}
