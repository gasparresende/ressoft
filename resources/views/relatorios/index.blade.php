@extends('layouts.app')

@section('title', 'Product')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Gestão de Mesas</h1>

        <div class="text-left mb-2">
            <a class="btn btn-primary" href="">Vendas</a>
            <a class="btn btn-info" href="">Caixas </a>
            <a class="btn btn-dark" href="">Produtos <i class="fa fa-dollar-sign"></i></a>
            <a class="btn btn-dark" href="">Cardápio Digital <i class="fa fa-history"></i></a>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listar Todos</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="mesas">
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
            $('#mesas').dataTable({
                "processing": true,
                "serverSide": true,
                "order": [0, 'desc'],
                ajax: {
                    url: "{{route('mesas.listar')}}",
                },
                columns: [
                    {data: 'id'},
                    {data: 'mesa'},
                    {
                        "render": function (data, type, row) {
                            return ``+
                                `<a title="View" class="btn btn-sm btn-primary mr-1" href="#"> <i class="fas fa-eye"></i> </a>` +
                                `<a title="View" class="btn btn-sm btn-warning mr-1" href="#"> <i class="fas fa-edit"></i> </a>` +
                            `<a title="View" class="btn btn-sm btn-danger mr-1" href="#"> <i class="fas fa-trash-alt"></i> </a>` ;
                        }
                    }
                ]
            })
        })
    </script>

@endsection
