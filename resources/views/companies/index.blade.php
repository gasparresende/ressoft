@extends('layouts.app')

@section('title', 'Company')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Empresas - Cadastros</h1>

        <div class="text-left">
            @if($companies->isEmpty())
                <a class="btn btn-primary mb-2" href="{{route('companies.create')}}">Novo</a>
            @endif
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
                            <th>Nome</th>
                            <th>NIF</th>
                            <th>Telemovel</th>
                            <th>E-mail</th>
                            <th>Ações</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($companies as $company)

                            <tr>
                                <td>{{$company->id}}</td>
                                <td>{{$company->nome}}</td>
                                <td>{{$company->nif}}</td>
                                <td>{{$company->telemovel}}</td>
                                <td>{{$company->email}}</td>
                                <td style="width: 200px">
                                    <a class="btn btn-primary"
                                       href="{{route('companies.show', $company->id)}}"><i
                                            class="fa fa-eye"></i></a>

                                    <form class="delete_item" style="display: inline"
                                          action="{{route('companies.destroy', $company->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i>
                                        </button>
                                    </form>

                                    <a class="btn btn-success" href="{{route('companies.edit', $company->id)}}"><i
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

@endsection

@section('js')

    <script>
        $('#entrada_produtos').submit(function (e) {
            e.preventDefault()

            var data = $("#entrada_produtos").serialize()
            postReq('{{route('input_products.store')}}', function () {
                sucesso(function () {
                    var res = xhttp.responseText
                    alert(res)
                })
            }, data)
        })
    </script>
@endsection
