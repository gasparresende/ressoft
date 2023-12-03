@extends('layouts.app')

@section('title', 'Product')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Gestão de Permissão</h1>

        <div class="text-left mb-2">
            <a class="btn btn-outline-primary" data-toggle="modal" href="#" id="btn_novo_permissions">Novo</a>

        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listar Todos</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="permissions">
                        <thead>
                        <tr>
                            <th scope="col" class="sort" data-sort="name">ID</th>
                            <th scope="col" class="sort" data-sort="name">Permission</th>
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
    <div id="modal_novo_permissions" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">permissions | Novo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('permissions.store')}}" role="form" enctype="multipart/form-data" method="post" id="modal_form_permissions">
                    @csrf

                    <input hidden type="number" name="id" class="id_permissions">
                    <div class="modal-body">

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="name">Nome *</label>
                                <input required autofocus class="form-control form-control-sm permissions_name" type="text" name="name">
                            </div>
                            <span class="text-warning mt-2" >Separar por ';'</span>

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

            $('#permissions').dataTable({
                "order": [0, 'desc'],
                ajax: {
                    url: "{{route('permissions.listar')}}",
                },
                columns: [
                    {data: 'id'},
                    {data: 'name'},
                    {
                        "render": function (data, type, row) {
                            return `<a title="Vizualizar" onclick="visualizar_permissionsView(${row.id})" class="btn btn-sm btn-info m-1" href="#"> <i class="fas fa-eye"></i> </a>` +
                                `<a title="Eliminar" onclick="eliminar('permissions/delete?id=${row.id}')" class="btn btn-sm btn-danger m-1" href="#"> <i class="fas fa-trash-alt"></i></a>` +
                                `<a title="Alterar" onclick="alterar_permissionsView(${row.id})" class="btn btn-sm btn-success m-1" href="#"> <i class="fas fa-edit"></i></a>`
                        }
                    }
                ]
            })


            //Executar
            novo_permission()
        })


        /*Funções*/
        function novo_permission() {
            $('#btn_novo_permissions').click(function () {
                $('.id_permissions').attr('disabled', true)
                $('#modal_novo_permissions form input').attr('readOnly', false)
                $('#modal_novo_permissions form select').attr('disabled', false)
                $('#modal_novo_permissions .modal-header').css('backgroundColor', '#11CDEF')
                $('#modal_novo_permissions .modal-title').html('Permissions | Novo')
                $('#modal_novo_permissions .modal-footer input').val('Salvar').show()
                $('#modal_form_permissions').trigger('reset')

                $('#modal_novo_permissions').modal('show')
            })
        }

        function visualizar_permissionsView(id) {
            $.get({
                url: 'permissions/show',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (data) {
                    $('.id_permissions').val(id)
                    Object.values(data).forEach(function (row) {
                        $('.permissions_name').val(row.name)

                        $('#modal_novo_permissions form input').attr('readOnly', true)
                        $('#modal_novo_permissions form select').attr('disabled', true)
                        $('#modal_novo_permissions .modal-header').css('backgroundColor', '#ADB5BD')
                        $('#modal_novo_permissions .modal-title').html('Permissions | Vizualizar')
                        $('#modal_novo_permissions .modal-footer input').hide()

                    })
                    //$('#modal_form_permissions').trigger('reset')
                    $('#modal_novo_permissions').modal('show')
                }

            })
        }

        function alterar_permissionsView(id) {
            //$('#modal_form_permissions').trigger('reset')
            $.get({
                url: 'permissions/show',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (data) {
                    $('.id_permissions').val(id)
                    Object.values(data).forEach(function (row) {

                        $('.permissions_name').val(row.name)

                        $('#modal_novo_permissions form input').attr('readOnly', false)
                        $('#modal_novo_permissions form select').attr('disabled', false)
                        $('#modal_novo_permissions .modal-header').css('backgroundColor', '#FFD600')
                        $('#modal_novo_permissions .modal-title').html('Permissions | Alterar')
                        $('#modal_novo_permissions .modal-footer input').val('Alterar').show()

                    })
                    $('#modal_novo_permissions').modal('show')
                }

            })
        }


    </script>

@endsection
