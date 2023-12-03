@extends('layouts.app')

@section('title', 'Product')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Gestão de Utilizadores</h1>

        <div class="text-left mb-2">
            <a class="btn btn-outline-primary" data-toggle="modal" href="#" id="btn_novo_users">Novo</a>

        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listar Todos</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="users">
                        <thead>
                        <tr>
                            <th scope="col" class="sort" data-sort="name">ID</th>
                            <th scope="col" class="sort" data-sort="name">username</th>
                            <th scope="col" class="sort" data-sort="status">E-mail</th>
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
    <div id="modal_novo_users" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Users | Novo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('users.store')}}" role="form" enctype="multipart/form-data" method="post" id="modal_form_users">
                    @csrf

                    <input hidden type="number" name="id" class="id_users">
                    <div class="modal-body">

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="username">Username *</label>
                                <input required autofocus class="form-control form-control-sm users_username" type="text" name="username">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="password">Password *</label>
                                <input required class="form-control form-control-sm users_password pwd" type="password" name="password">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="confirmar">Confirmar Password *</label>
                                <input required class="form-control form-control-sm users_confirmar pwd" type="password" name="password_confirmation">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-12">
                                <label for="email">E-mail </label>
                                <input class="form-control form-control-sm users_email" type="email" name="email">
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


    <div id="modal_reset_users" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Users | reset</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('users.reset')}}" role="form" enctype="multipart/form-data" method="post" id="modal_form_users_reset">
                    @csrf

                    <input hidden type="number" name="id" class="id_users">
                    <div class="modal-body">

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="username">Username *</label>
                                <input required autofocus class="form-control form-control-sm users_username" type="text" name="username">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="password">Password *</label>
                                <input required class="form-control form-control-sm users_password pwd" type="password" name="password" autocomplete="off">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="confirmar">Confirmar Password *</label>
                                <input required class="form-control form-control-sm users_confirmar pwd" type="password" name="password_confirmation" autocomplete="off">
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

            $('#users').dataTable({
                "order": [0, 'desc'],
                ajax: {
                    url: "{{route('users.listar')}}",
                },
                columns: [
                    {data: 'id'},
                    {data: 'username'},
                    {data: 'email'},
                    {
                        "render": function (data, type, row) {
                            return `<a title="Vizualizar" onclick="visualizar_usersView(${row.id})" class="btn btn-sm btn-info m-1" href="#"> <i class="fas fa-eye"></i> </a>` +
                                `<a title="Reset Password" onclick="resetPasswordView(${row.id})"  class="btn btn-sm btn-warning m-1" href="#"> <i class="fas fa-key"></i></a>` +
                                `<a title="Eliminar" onclick="eliminar('users/delete?id=${row.id}')" class="btn btn-sm btn-danger m-1" href="#"> <i class="fas fa-trash-alt"></i></a>` +
                                `<a title="Alterar" onclick="alterar_usersView(${row.id})" class="btn btn-sm btn-success m-1" href="#"> <i class="fas fa-edit"></i></a>`
                        }
                    }
                ]
            })


            //Executar
            novo_user()
        })


        /*Funções*/
        function novo_user() {
            $('#btn_novo_users').click(function () {
                $('.id_users').attr('disabled', true)
                $('#modal_novo_users form input').attr('readOnly', false)
                $('#modal_novo_users form select').attr('disabled', false)
                $('#modal_novo_users .modal-header').css('backgroundColor', '#11CDEF')
                $('#modal_novo_users .modal-title').html('Users | Novo')
                $('#modal_novo_users .modal-footer input').val('Salvar').show()
                $('#modal_form_users').trigger('reset')

                $('#modal_novo_users').modal('show')
            })
        }

        function visualizar_usersView(id) {
            $.get({
                url: 'users/show',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (data) {
                    $('.id_users').val(id)
                    Object.values(data).forEach(function (row) {
                        $('.users_username').val(row.username)
                        $('.users_password').val(row.password)
                        $('.users_email').val(row.email)

                        $('#modal_novo_users form input').attr('readOnly', true)
                        $('#modal_novo_users form select').attr('disabled', true)
                        $('#modal_novo_users .modal-header').css('backgroundColor', '#ADB5BD')
                        $('#modal_novo_users .modal-title').html('Users | Vizualizar')
                        $('#modal_novo_users .modal-footer input').hide()

                    })
                    //$('#modal_form_users').trigger('reset')
                    $('#modal_novo_users').modal('show')
                }

            })
        }

        function alterar_usersView(id) {
            //$('#modal_form_users').trigger('reset')
            $.get({
                url: 'users/show',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (data) {
                    $('.id_users').val(id)
                    Object.values(data).forEach(function (row) {

                        $('.users_username').val(row.username)
                        $('.users_password').val(row.password)
                        $('.users_email').val(row.email)
                        $('.pwd').val('').attr('disabled', true)

                        $('#modal_novo_users form input').attr('readOnly', false)
                        $('#modal_novo_users form select').attr('disabled', false)
                        $('#modal_novo_users .modal-header').css('backgroundColor', '#FFD600')
                        $('#modal_novo_users .modal-title').html('Users | Alterar')
                        $('#modal_novo_users .modal-footer input').val('Alterar').show()

                    })
                    $('#modal_novo_users').modal('show')
                }

            })
        }

        function resetPasswordView(id) {
            //$('#modal_form_users').trigger('reset')
            $.get({
                url: 'users/show',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (data) {
                    $('.id_users').val(id)
                    Object.values(data).forEach(function (row) {

                        $('.users_username').val(row.username).attr('readOnly', true)

                        $('#modal_reset_users .modal-header').css('backgroundColor', '#FFD600')
                        $('#modal_reset_users .modal-title').html('Users | Reset Password')
                        $('#modal_reset_users .modal-footer input').val('Alterar').show()

                    })
                    $('#modal_reset_users').modal('show')
                }

            })
        }
    </script>

@endsection
