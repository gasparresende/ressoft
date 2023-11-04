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


    <div class="modal abrir_caixa" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Abrir Caixa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('caixas.store')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="">Utilizador*</label>
                                <select required name="users_id" id="" class="form-control">
                                    <option value="">-- select --</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->username}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Saldo Inicial *</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Kz</span>
                                    </div>
                                    <input required type="number" class="form-control" value="0"
                                           aria-label="Amount (to the nearest dollar)" name="saldo_inicial">
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="">Data *</label>
                                <input required min="{{data_formatada(now(), 'Y-m-d')}}" value="{{data_formatada(now(), 'Y-m-d')}}" type="date" class="form-control" name="data_caixa">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Abrir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                    {data: 'total'},
                    {
                        "render": function (data, type, row) {
                            if (row.status == 1) {
                                return `<span class="badge badge-success">Aberto</span>`
                            } else {
                                return `<span class="badge badge-danger">Fechado</span>`
                            }
                        }
                    },
                    {
                        "render": function (data, type, row) {
                            return `<a title="Vizualizar Meios de Pagamentos" class="btn-sm btn-primary mr-1" href="#"><i class="fa fa-eye"></i></a>` +

                                `<a  title="Fechar Caixa" data-toggle="modal" class="btn-sm btn-danger mr-1" href="#" ><i class="fa fa-times-circle"></i></a>` +

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
