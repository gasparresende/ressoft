@extends('layouts.app')

@section('title', 'Categoria')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Categorias - Cadastros</h1>

        <div class="text-left">
            <a class="btn btn-primary mb-2" href="{{route('categories.create')}}">Novo</a>
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
                            <th>Categoria</th>
                            <th>Ações</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($categories as $category)

                            <tr>
                                <td>{{$category->id}}</td>
                                <td>{{$category->categoria}}</td>

                                <td style="width: 200px">
                                    <a class="btn btn-primary"
                                       href="{{route('categories.show', $category->id)}}"><i
                                            class="fa fa-eye"></i></a>

                                    <form class="delete_item" style="display: inline"
                                          action="{{route('categories.destroy', $category->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i>
                                        </button>
                                    </form>

                                    <a class="btn btn-success" href="{{route('categories.edit', $category->id)}}"><i
                                            class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <style>
                        .w-5{
                            display: none;
                        }
                        .hidden{
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
