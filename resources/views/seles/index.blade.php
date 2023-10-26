@extends('layouts.app')

@section('title', 'sele')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Vendas - Cadastros</h1>

        <div class="mb-3">
            <div class="text-left">
                <a class="btn btn-primary" href="{{route('seles.create')}}">Novo</a>

                @if (caixaAbertoDiaAnterior()->status)
                    <a class="btn btn-danger" href="{{route('seles.create')}}">Fechar Caixa- {{data_formatada(caixaAbertoDiaAnterior()->data_caixa)}}</a>

                @elseif(isCaixaFechado())
                    <a class="btn btn-success" href="{{route('seles.create')}}">Abrir Caixa- {{data_formatada(date(now()))}}</a>
                @endif
            </div>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listar Todos</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="seles">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Data</th>
                            <th>Valor</th>
                            <th>Cliente</th>
                            <th>Ações</th>
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
        function formatar_data(data) {
            let split = data.split(' '); //separa a data da hora
            let formmated = split[0].split('-');
            return formmated[2] + '-' + formmated[1] + '-' + formmated[0]+' '+split[1]
        }

        $(function () {
            $('#seles').dataTable({
                "processing": true,
                "serverSide": true,
                "order": [0, 'desc'],
                ajax: {
                    url: "{{route('seles.listar')}}",
                },
                columns: [
                    {data: 'numero'},
                    {data: 'username'},
                    {
                        "render": function (data, type, row) {
                            return formatar_data(row.data)
                        }
                    },
                    {data: 'total'},
                    {data: 'customer'},
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
