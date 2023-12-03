@extends('layouts.app')

@section('title', 'Product')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Gestão de Cliente</h1>

        <div class="text-left mb-2">
            <a class="btn btn-outline-primary" data-toggle="modal" href="#" id="btn_novo_clientes">Novo</a>

        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listar Todos</h6>
            </div>

            <div class="card-body" style="padding: 1.25rem 0.5rem;">
                <div class="table-responsive">
                    <table class="table table-striped" id="clientes">
                        <thead>
                        <tr>
                            <th scope="col" class="sort" data-sort="name">ID</th>
                            <th scope="col" class="sort" data-sort="name">Nome</th>
                            <th scope="col" class="sort" data-sort="name">NIF</th>
                            <th scope="col" class="sort" data-sort="status">E-mail</th>
                            <th scope="col" class="sort" data-sort="status">Telemóvel</th>
                            <th scope="col" class="sort" data-sort="status">Ações</th>

                        </tr>
                        </thead>
                        <tbody class="list">

                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>


    <!-- Modal -->
    <div id="modal_novo_clientes" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Clientes | Novo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('clientes.store')}}" role="form" enctype="multipart/form-data" method="post" id="modal_form_clientes">
                    @csrf

                    <input hidden type="number" name="id" class="id_clientes">
                    <div class="modal-body">

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="nome">Nome *</label>
                                <input required autofocus class="form-control form-control-sm clientes_nome" type="text" name="nome">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="nif">NIF *</label>
                                <input required class="form-control form-control-sm clientes_nif" type="text" name="nif">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="telemovel">Telemóvel </label>
                                @php
                                    $tele = Request::input('telemovel');
                                    if(strlen($tele)>16 || strlen($tele)<16){}
                                @endphp
                                <input class="form-control form-control-sm telefone clientes_telemovel" type="text" name="telemovel" id="telemovel">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email">E-mail </label>
                                <input class="form-control form-control-sm clientes_email" type="email" name="email">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="endereco">Endereço </label>
                                <input class="form-control form-control-sm clientes_endereco" type="text" name="endereco">
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer" style="border-top: 1px #0da5c0 solid">
                        <input type='submit' id="salvar_ja" class='btn btn-success' value='Salvar'>
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

            $('#clientes').dataTable({
                "order": [0, 'desc'],
                ajax: {
                    url: "{{route('clientes.listar')}}",
                },
                columns: [
                    {data: 'id'},
                    {data: 'nome'},
                    {data: 'nif'},
                    {data: 'email'},
                    {data: 'telemovel'},
                    {
                        "render": function (data, type, row) {
                            return `<a title="Vizualizar" onclick="visualizar_clientesView(${row.id})" class="btn btn-sm btn-info m-1" href="#"> <i class="fas fa-eye"></i> </a>` +
                                `<a title="Eliminar" onclick="eliminar('clientes/delete?id=${row.id}')" class="btn btn-sm btn-danger m-1" href="#"> <i class="fas fa-trash-alt"></i></a>` +
                                `<a title="Alterar" onclick="alterar_clientesView(${row.id})" class="btn btn-sm btn-success m-1" href="#"> <i class="fas fa-edit"></i></a>`
                        }
                    }
                ]
            })

            $('#modal_form_clientes').keypress(function () {
                var tele = document.getElementById('telemovel');
                if (tele.length<16 || tele.length>16){
                    $('#salvar_ja').attr('disabled', false)
                }
            })

            //Executar
            novo_cliente()
        })




        /*Funções*/
        function novo_cliente() {
            $('#btn_novo_clientes').click(function () {
                $('.id_clientes').attr('disabled', true)
                $('#modal_novo_clientes form input').attr('readOnly', false)
                $('#modal_novo_clientes form select').attr('disabled', false)
                $('#modal_novo_clientes .modal-header').css('backgroundColor', '#11CDEF')
                $('#modal_novo_clientes .modal-title').html('Clientes | Novo')
                $('#modal_novo_clientes .modal-footer input').val('Salvar').show()
                $('#modal_form_clientes').trigger('reset')

                $('#modal_novo_clientes').modal('show')
            })
        }

        function visualizar_clientesView(id) {
            $.get({
                url: 'clientes/show',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (data) {
                    $('.id_clientes').val(id)
                    Object.values(data).forEach(function (row) {
                        $('.clientes_nome').val(row.nome)
                        $('.clientes_nif').val(row.nif)
                        $('.clientes_telemovel').val(row.telemovel)
                        $('.clientes_email').val(row.email)
                        $('.clientes_endereco').val(row.endereco)
                        $('.clientes_contas_id').val(row.contas_id)

                        $('#modal_novo_clientes form input').attr('readOnly', true)
                        $('#modal_novo_clientes form select').attr('disabled', true)
                        $('#modal_novo_clientes .modal-header').css('backgroundColor', '#ADB5BD')
                        $('#modal_novo_clientes .modal-title').html('clientes | Vizualizar')
                        $('#modal_novo_clientes .modal-footer input').hide()

                    })
                    //$('#modal_form_clientes').trigger('reset')
                    $('#modal_novo_clientes').modal('show')
                }

            })
        }

        function alterar_clientesView(id) {
            //$('#modal_form_clientes').trigger('reset')
            $.get({
                url: 'clientes/show',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (data) {
                    $('.id_clientes').val(id)
                    Object.values(data).forEach(function (row) {

                        $('.clientes_nome').val(row.nome)
                        $('.clientes_nif').val(row.nif)
                        $('.clientes_telemovel').val(row.telemovel)
                        $('.clientes_email').val(row.email)
                        $('.clientes_endereco').val(row.endereco)
                        $('.clientes_contas_id').val(row.contas_id)

                        $('#modal_novo_clientes form input').attr('readOnly', false)
                        $('#modal_novo_clientes form select').attr('disabled', false)
                        $('#modal_novo_clientes .modal-header').css('backgroundColor', '#FFD600')
                        $('#modal_novo_clientes .modal-title').html('clientes | Alterar')
                        $('#modal_novo_clientes .modal-footer input').val('Alterar').show()

                    })
                    $('#modal_novo_clientes').modal('show')
                }

            })
        }
    </script>

@endsection
