@extends('layouts.app')

@section('title', 'Product')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Gestão de Facturas</h1>

        <div class="text-left mb-2">
            <a class="btn btn-outline-primary" href="{{route('facturas.create')}}" >Novo</a>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listar Todos</h6>
            </div>
            <div class="card-body" style="padding: 1.25rem .5rem">
                <div class="table-responsive">
                    <table class="table " id="facturas">
                        <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Número</th>
                            <th>Nome</th>
                            <th>Valor Bruto</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
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
            $('#facturas').dataTable({
                "order": [5, 'desc'],
                "createdRow": function(row, data, dataIndex){
                    $(row).attr('title', 'ID: '+data.id)
                    if(data.sigla === 'PP'){
                        $(row).addClass('text-danger');
                    }
                    else if(data.sigla === 'FR'){
                        $(row).addClass('text-dark');
                    }
                    else if(data.sigla === 'NC'){
                        $(row).addClass('text-success');
                    }
                },
                ajax: {
                    url: "{{route('facturas.listar')}}",
                },
                columns: [
                    {data: 'tipo'},
                    {data: 'numero'},
                    {data: 'nome'},
                    {data: 'valor_total'},
                    {data: 'data_emissao'},
                    {
                        "render": function (data, type, row) {
                            return ``+
                            `<a title="Factura Térmica"  class="btn btn-sm btn-outline-dark m-1" href="report/${row.id}/facturas/termica"> <i class="fas fa-print"></i></a>`+
                            `<a title="Factura A4"  class="btn btn-sm btn-secondary m-1" href="report/${row.id}/facturas/preview"> <i class="fas fa-print"></i></a>`+
                                `<a ${row.sigla == 'NC' || row.sigla == 'PP'? 'hidden' : ''} title="Nota de Crédito"  class="btn btn-sm btn-danger m-1" href="/nota_credito/${row.id}/create"> <i class="fas fa-ban"></i></a>`
                        }
                    }
                ]
            })
        })
    </script>

@endsection
