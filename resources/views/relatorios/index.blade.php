@extends('layouts.app')

@section('title', 'Product')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Gestão de Relatórios</h1>

        <div class="text-left mb-2">
            <a class="btn btn-dark" href="">Produtos <i class="fa fa-dollar-sign"></i></a>
            <a class="btn btn-dark" href="{{route('relatorios.cardapio')}}">Cardápio Digital <i class="fa fa-history"></i></a>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listar Todos</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="ralatorios">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Número</th>
                            <th>Açoes</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

@endsection

@section('js')

    <script>
        $(function () {

        })
    </script>

@endsection
