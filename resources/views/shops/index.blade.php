@extends('layouts.app')

@section('title', 'Shop')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Lojas - Cadastros</h1>

        <div class="text-left">
            <a class="btn btn-primary mb-2" href="{{route('shops.create')}}">Novo</a>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listar Todos</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered tabela">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Loja</th>
                            <th>Ações</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($shops as $shop)

                            <tr>
                                <td>{{$shop->id}}</td>
                                <td>{{$shop->loja}}</td>

                                <td style="width: 200px">

                                    <a class="btn btn-primary"
                                       href="{{route('shops.show', $shop->id)}}"><i
                                            class="fa fa-eye"></i></a>


                                    <form class="delete_item" style="display: inline"
                                          action="{{route('shops.destroy', $shop->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i>
                                        </button>
                                    </form>

                                    <a class="btn btn-success" href="{{route('shops.edit', $shop->id)}}"><i
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
