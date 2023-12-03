@extends('layouts.app')

@section('title', 'Product')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Gestão de Contas</h1>

        <div class="text-left mb-2">
            <a href="{{route('contas.create')}}" class="btn btn-sm btn-outline-primary" data-toggle="modal"
               id="btn_novo_contas">Novo </a>

        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listar Todos</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="contas">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nº Conta</th>
                            <th>Descrição</th>
                            <th>Tipo</th>
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

    <!-- Modal -->
    <div id="modal_novo_contas" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Contas | Novo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('contas.store')}}" role="form" enctype="multipart/form-data" method="post" id="modal_form_contas">
                    @csrf

                    <input hidden type="number" name="id" class="id_contas">
                    <div class="modal-body">

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="">Descrição *</label>
                                <input required class="form-control form-control-sm contas_descricao" type="text" name="descricao" >
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="">Número *</label>
                                <input required class="form-control form-control-sm contas_conta" type="text" name="conta" >
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tipo">Tipo de Conta *</label>
                                <select required class="form-control form-control-sm contas_tipo" name="tipo" >
                                    <option value="">-- selecione uma opçao --</option>
                                    <option value="Activo">Activo</option>
                                    <option value="Passivo">Passivo</option>
                                    <option value="Capital Próprio">Capital Próprio</option>
                                    <option value="Custos">Custos</option>
                                    <option value="Proveitos">Proveitos</option>
                                    <option value="Resultados">Resultados</option>
                                </select>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer" style="border-top: 1px #0da5c0 solid">
                        <input type="submit" class="btn btn-success" value="Salvar">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- FIM Modal -->

@endsection

@section('js')

    <script>
        $(function () {

            $('#contas').dataTable({
                "order": [0, 'desc'],
                ajax: {
                    url: "{{route('contas.listar')}}",
                },
                columns: [
                    {data: 'id'},
                    {data: 'conta'},
                    {data: 'descricao'},
                    {data: 'tipo'},
                    {
                        "render": function (data, type, row) {
                            return `<a title="Vizualizar" onclick="visualizar_contasView(${row.id})" class="btn btn-sm btn-info m-1" href="#"> <i class="fas fa-eye"></i> </a>` +
                                `<a title="Eliminar" onclick="eliminar('contas/delete?id=${row.id}')" class="btn btn-sm btn-danger m-1" href="#"> <i class="fas fa-trash-alt"></i></a>` +
                                `<a title="Alterar" onclick="alterar_contasView(${row.id})" class="btn btn-sm btn-success m-1" href="#"> <i class="fas fa-edit"></i></a>`
                        }
                    }
                ]
            })


            //Executar
            novo_conta()
        })


        /*Funções*/
        function novo_conta() {
            $('#btn_novo_contas').click(function () {
                $('.id_contas').attr('disabled', true)
                $('#modal_novo_contas form input').attr('readOnly', false)
                $('#modal_novo_contas form select').attr('disabled', false)
                $('#modal_novo_contas .modal-header').css('backgroundColor', '#11CDEF')
                $('#modal_novo_contas .modal-title').html('Contas | Novo')
                $('#modal_novo_contas .modal-footer input').val('Salvar').show()
                $('#modal_form_contas').trigger('reset')

                $('#modal_novo_contas').modal('show')
            })
        }

        function visualizar_contasView(id) {
            $.get({
                url: 'contas/show',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (data) {
                    $('.id_contas').val(id)
                    Object.values(data).forEach(function (row) {
                        $('.contas_descricao').val(row.descricao)
                        $('.contas_conta').val(row.conta)
                        $('.contas_tipo').val(row.tipo)

                        $('#modal_novo_contas form input').attr('readOnly', true)
                        $('#modal_novo_contas form select').attr('disabled', true)
                        $('#modal_novo_contas .modal-header').css('backgroundColor', '#ADB5BD')
                        $('#modal_novo_contas .modal-title').html('Contas | Vizualizar')
                        $('#modal_novo_contas .modal-footer input').hide()

                    })
                    //$('#modal_form_contas').trigger('reset')
                    $('#modal_novo_contas').modal('show')
                }

            })
        }

        function alterar_contasView(id) {
            //$('#modal_form_contas').trigger('reset')
            $.get({
                url: 'contas/show',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (data) {
                    $('.id_contas').val(id)
                    Object.values(data).forEach(function (row) {

                        $('.contas_descricao').val(row.descricao)
                        $('.contas_conta').val(row.conta)
                        $('.contas_tipo').val(row.tipo)

                        $('#modal_novo_contas form input').attr('readOnly', false)
                        $('#modal_novo_contas form select').attr('disabled', false)
                        $('#modal_novo_contas .modal-header').css('backgroundColor', '#FFD600')
                        $('#modal_novo_contas .modal-title').html('Contas | Alterar')
                        $('#modal_novo_contas .modal-footer input').val('Alterar').show()

                    })
                    $('#modal_novo_contas').modal('show')
                }

            })
        }
    </script>

@endsection
