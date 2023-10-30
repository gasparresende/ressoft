@extends('layouts.app')

@section('title', 'Product')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Produtos - Cadastros</h1>

        <div class="text-left">
            <a class="btn btn-primary mb-2" href="{{route('products.create')}}">Novo</a>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listar Todos</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="products">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Produto</th>
                            <th>Preço Venda</th>
                            <th>Preço Compra</th>
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
            $('#products').dataTable({
                "processing": true,
                "serverSide": true,
                "order": [0, 'desc'],
                ajax: {
                    url: "{{route('products.listar')}}",
                },
                columns: [
                    {data: 'id'},
                    {data: 'codigo'},
                    {data: 'product'},
                    {data: 'preco_venda'},
                    {data: 'preco_compra'},
                    {
                        "render": function (data, type, row) {
                            return ``+
                                `<a title="Delete" class="btn btn-sm btn-danger mr-1" href="#"> <i class="fas fa-trash-alt"></i> </a>` +
                                `<a title="Alterar" class="btn btn-sm btn-primary mr-1" href="/products/${row.id}/edit"> <i class="fas fa-edit"></i> </a>` +
                                `<a title="Vizualizar" class="btn btn-sm btn-info mr-1" href="{{route('products.show', '')}}/${row.id}"> <i class="fas fa-eye"></i> </a>`
                        }
                    }
                ]
            })
        })
    </script>

@endsection
