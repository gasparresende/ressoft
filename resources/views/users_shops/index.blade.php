@extends('layouts.app')

@section('title', 'Users_shopp')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Users Loja - Cadastros</h1>

        <div class="text-left">
            <a class="btn btn-primary mb-2" href="{{route('users_shops.create')}}">Novo</a>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listar Todos</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-striped tabela">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuário</th>
                            <th>Loja</th>
                            <th>Ações</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($users_shops as $users_shop)

                            <tr>
                                <td>{{$users_shop->id}}</td>
                                <td>{{$users_shop->users->username}}</td>
                                <td>{{$users_shop->shops->loja}}</td>

                                <td style="width: 200px">


                                    <form class="delete_item" style="display: inline"
                                          action="{{route('users_shops.destroy', $users_shop->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i>
                                        </button>
                                    </form>

                                    <a class="btn btn-success" href="{{route('users_shops.edit', $users_shop->id)}}"><i
                                            class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <style>
                        .w-5 {
                            display: none;
                        }

                        .hidden {
                            display: none;
                        }
                    </style>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

@endsection

@section('js')

@endsection
