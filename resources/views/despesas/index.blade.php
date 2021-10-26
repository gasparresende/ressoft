@extends('layouts.app')

@section('title', 'Product')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Despesas - Cadastros</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listar Todos</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="despesas">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Descricao</th>
                            <th>Valor</th>
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
            $('#despesas').dataTable({
                "processing": true,
                "serverSide": true,
                "order": [0, 'desc'],
                ajax: {
                    url: "{{route('despesas.listar')}}",
                },
                columns: [
                    {data: 'id'},
                    {data: 'descricao'},
                    {data: 'valor'},
                    {
                        "render": function (data, type, row) {
                            return `<a title="View" class="btn btn-sm btn-danger mr-1" href="#"> <i class="fas fa-ban"></i> </a>` +
                                `<a title="View" class="btn btn-sm btn-success" href="#"> <i class="fas fa-download"></i> </a>`
                        }
                    }
                ]
            })
        })
    </script>

@endsection
