@extends('layouts.app')

@section('title', 'Product')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Gestão de Empresa</h1>

        <div class="text-left mb-2">
            @if (\App\Models\Empresa::all()->count() == 0)
                <div class="text-left">
                    <a class="btn btn-primary" data-toggle="modal" href="#" id="btn_novo_empresas">Novo</a>
                </div>
            @endif
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listar Todos</h6>
            </div>

            <div class="card-body" style="padding: 1.25rem 0.5rem;">
                <div class="table-responsive">
                    <table class="table table-striped" id="empresas">
                        <thead>
                        <tr>
                            <th scope="col" class="sort" data-sort="name">ID</th>
                            <th scope="col" class="sort" data-sort="name">Nome</th>
                            <th scope="col" class="sort" data-sort="status">E-mail</th>
                            <th scope="col" class="sort" data-sort="status">Telemóvel</th>
                            <th scope="col" class="sort" data-sort="status">Regime IVA</th>
                            <th scope="col" class="sort" data-sort="status">Taxa IVA</th>
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
    <div class="modal fade w-80" id="modal_novo_empresas" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px; padding: 10px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="h6 modal-title">Empresas | Novo</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('empresas.store')}}" role="form" enctype="multipart/form-data" method="post"
                          id="modal_form_empresas">
                        @csrf

                        <input hidden type="number" name="id" class="id_empresas">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="nome">Nome *</label>
                                <input required autofocus class="form-control form-control-sm empresas_nome" type="text"
                                       name="nome_empresa">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="nif">NIF *</label>
                                <input required class="form-control form-control-sm empresas_nif" type="text"
                                       name="nif_empresa">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="telemovel">Telemóvel </label>
                                <input class="form-control form-control-sm telefone empresas_telemovel" type="text"
                                       name="telemovel_empresa">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email">E-mail </label>
                                <input class="form-control form-control-sm empresas_email" type="email"
                                       name="email_empresa">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="endereco">Endereço </label>
                                <input class="form-control form-control-sm empresas_endereco" type="text"
                                       name="endereco_empresa">
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="">Logotipo </label>
                                <input class="form-control form-control-sm empresas_logotipo" type="file"
                                       name="logotipo_empresa">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">Regime IVA </label>
                                <select class="form-control form-control-sm empresas_regimes_id" name="regimes_id">
                                    <option value="">-- selecione uma opção --</option>
                                    @foreach($regimes as $regime)
                                        <option value="{{$regime->id}}">{{$regime->motivo}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">Taxa IVA </label>
                                <select class="form-control form-control-sm empresas_taxas_id" name="taxas_id">
                                    <option value="">-- selecione uma opção --</option>
                                    @foreach($taxas as $taxa)
                                        <option value="{{$taxa->id}}">{{$taxa->obs}} {{$taxa->taxa}} %</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer mt-3" style="border-top: 1px #0da5c0 solid">
                            <input type="submit" class="btn btn-success" value="Salvar">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM Modal -->

@endsection

@section('js')

    <script>
        $(function () {

            $('#empresas').dataTable({
                "order": [0, 'desc'],
                ajax: {
                    url: "{{route('empresas.listar')}}",
                },
                columns: [
                    {data: 'id'},
                    {data: 'nome_empresa'},
                    {data: 'email_empresa'},
                    {data: 'telemovel_empresa'},
                    {data: 'motivo'},
                    {data: 'taxa'},
                    {
                        "render": function (data, type, row) {
                            return `<a title="Vizualizar" onclick="visualizar_empresasView(${row.id})" class="btn btn-sm btn-info m-1" href="#"> <i class="fas fa-eye"></i> </a>` +
                                `<a title="Eliminar" onclick="eliminar('empresas/delete?id=${row.id}')" class="btn btn-sm btn-danger m-1" href="#"> <i class="fas fa-trash-alt"></i></a>` +
                                `<a title="Alterar" onclick="alterar_empresasView(${row.id})" class="btn btn-sm btn-success m-1" href="#"> <i class="fas fa-edit"></i></a>`
                        }
                    }
                ]
            })


            //Executar
            novo_empresa()
        })


        /*Funções*/
        function novo_empresa() {
            $('#btn_novo_empresas').click(function () {
                $('.id_empresas').attr('disabled', true)
                $('#modal_novo_empresas form input').attr('readOnly', false)
                $('#modal_novo_empresas form select').attr('disabled', false)
                $('#modal_novo_empresas .modal-header').css('backgroundColor', '#11CDEF')
                $('#modal_novo_empresas .modal-title').html('empresas | Novo')
                $('#modal_novo_empresas .modal-footer input').val('Salvar').show()
                $('#modal_form_empresas').trigger('reset')

                $('#modal_novo_empresas').modal('show')
            })
        }

        function visualizar_empresasView(id) {
            $.get({
                url: 'empresas/show',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (data) {
                    $('.id_empresas').val(id)
                    Object.values(data).forEach(function (row) {
                        $('.empresas_nome').val(row.nome_empresa)
                        $('.empresas_nif').val(row.nif_empresa)
                        $('.empresas_telemovel').val(row.telemovel_empresa)
                        $('.empresas_email').val(row.email_empresa)
                        $('.empresas_endereco').val(row.endereco_empresa)
                        $('.empresas_regimes_id').val(row.regimes_id)
                        $('.empresas_taxas_id').val(row.taxas_id)

                        $('#modal_novo_empresas form input').attr('readOnly', true)
                        $('#modal_novo_empresas form select').attr('disabled', true)
                        $('#modal_novo_empresas .modal-header').css('backgroundColor', '#ADB5BD')
                        $('#modal_novo_empresas .modal-title').html('Empresas | Vizualizar')
                        $('#modal_novo_empresas .modal-footer input').hide()

                    })
                    //$('#modal_form_empresas').trigger('reset')
                    $('#modal_novo_empresas').modal('show')
                }

            })
        }

        function alterar_empresasView(id) {
            //$('#modal_form_empresas').trigger('reset')
            $.get({
                url: 'empresas/show',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (data) {
                    $('.id_empresas').val(id)
                    Object.values(data).forEach(function (row) {

                        $('.empresas_nome').val(row.nome_empresa)
                        $('.empresas_nif').val(row.nif_empresa)
                        $('.empresas_telemovel').val(row.telemovel_empresa)
                        $('.empresas_email').val(row.email_empresa)
                        $('.empresas_endereco').val(row.endereco_empresa)
                        $('.empresas_regimes_id').val(row.regimes_id)
                        $('.empresas_taxas_id').val(row.taxas_id)

                        $('#modal_novo_empresas form input').attr('readOnly', false)
                        $('#modal_novo_empresas form select').attr('disabled', false)
                        $('#modal_novo_empresas .modal-header').css('backgroundColor', '#FFD600')
                        $('#modal_novo_empresas .modal-title').html('Empresas | Alterar')
                        $('#modal_novo_empresas .modal-footer input').val('Alterar').show()

                    })
                    $('#modal_novo_empresas').modal('show')
                }

            })
        }
    </script>

@endsection
