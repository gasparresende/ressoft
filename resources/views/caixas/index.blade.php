@extends('layouts.app')

@section('title', 'Caixa')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Caixas - Cadastros</h1>

        <div class="text-left">
            <a class="btn btn-primary mb-2" data-toggle="modal" href=".abrir_caixa">Abrir Caixa</a>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listar Todos</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="caixas">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Data</th>
                            <th>Saldo Inicial</th>
                            <th>Total</th>
                            <th>Satus</th>
                            <th style="width: 10%">Ações</th>
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
            $('#caixas').dataTable({
                "processing": true,
                "serverSide": true,
                "order": [0, 'desc'],
                ajax: {
                    url: "{{route('caixas.listar')}}",
                },
                columns: [
                    {data: 'id_caixa'},
                    {data: 'username'},
                    {data: 'data_caixa'},
                    {data: 'saldo_inicial'},
                    {data: 'saldo'},
                    {data: 'status'},
                    {
                        "render": function (data, type, row) {
                            return `<a title="Vizualizar Meios de Pagamentos" class="btn-sm btn-primary mr-1" href="#"><i class="fa fa-eye"></i></a>`+

                                    `<a  title="Fechar Caixa" data-toggle="modal" class="btn-sm btn-danger mr-1" href="#" ><i class="fa fa-times-circle"></i></a>`+

                                    `<a title="Relatório de Caixa" class="btn-sm btn-success" href="#"><i class="fa fa-file-pdf"></i></a>`
                        }
                    }
                ]
            })
        })

        function fechar_caixa(id) {
            $.get({
                url: "{{route('caixas.fechar')}}",
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (data) {
                    alert('da')
                    //$('#modal_form_cursos').trigger('reset')
                    //$('.fechar_caixa').modal('show')
                }

            })
        }
    </script>

@endsection
