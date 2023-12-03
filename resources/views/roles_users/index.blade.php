@extends('layouts.app')

@section('title', 'Product')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Roles - Users</h1>

        <div class="text-left mb-2">
            <a class="btn btn-outline-primary" data-toggle="modal" href="#" id="btn_novo_roles_users">Novo</a>

        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listar Todos</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="roles_users">
                        <thead>
                        <tr>
                            <th scope="col">User</th>
                            <th scope="col">Role</th>
                            <th scope="col">Ações</th>

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
    <div id="modal_novo_roles_users" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Role - Users | Novo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('roles_users.store')}}" role="form" enctype="multipart/form-data"
                      method="post" id="modal_form_roles_users">
                    @csrf

                    <input hidden type="number" name="id" class="id_roles_users">
                    <div class="modal-body">

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="name">Username *</label>
                                <select required class="form-control form-control-sm roles_users_users_id" name="users_id">
                                    <option value="">-- selecione o usuário --</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->username}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-12">
                                <label for="name">Roles *</label>
                                <div class="res_roles">

                                </div>

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

            $('.roles_users_users_id').change(function () {
                var res = ''
                $.get({
                    url: '{{route('roles_users.listar_by_id')}}',
                    dataType: 'json',
                    data: {
                        id: $('.roles_users_users_id').val()
                    },
                    success: function (data) {
                        Object.values(data).forEach(function (row) {
                            res += `<div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="${row.id}" id="role${row.id}" name="roles_id[]">
                                                <label class="form-check-label" for="role${row.id}">
                                                    ${row.name}
                                                </label>
                                            </div>`
                        })
                        $('.res_roles').html(res)
                    }

                })
            })

            $('#roles_users').dataTable({
                "order": [0, 'desc'],
                ajax: {
                    url: "{{route('roles_users.listar')}}",
                },
                columns: [
                    {data: 'username'},
                    {data: 'name'},
                    {
                        "render": function (data, type, row) {
                            return `<a title="Eliminar" onclick="eliminar('roles_users/delete?role_id=${row.role_id}&model_id=${row.model_id}')" class="btn btn-sm btn-danger m-1" href="#"> <i class="fas fa-trash-alt"></i></a>`
                        }
                    }
                ]
            })

            //Executar
            novo_roles_user()
        })


        /*Funções*/
        function novo_roles_user() {
            $('#btn_novo_roles_users').click(function () {
                $('.id_roles_users').attr('disabled', true)
                $('#modal_novo_roles_users form input').attr('readOnly', false)
                $('#modal_novo_roles_users form select').attr('disabled', false)
                $('#modal_novo_roles_users .modal-header').css('backgroundColor', '#11CDEF')
                $('#modal_novo_roles_users .modal-title').html('Roles - Users | Novo')
                $('#modal_novo_roles_users .modal-footer input').val('Salvar').show()
                $('#modal_form_roles_users').trigger('reset')

                $('#modal_novo_roles_users').modal('show')
            })
        }

        function visualizar_roles_usersView(id) {
            $.get({
                url: 'roles_users/show',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (data) {
                    $('.id_roles_users').val(id)
                    Object.values(data).forEach(function (row) {
                        $('.roles_users_name').val(row.name)

                        $('#modal_novo_roles_users form input').attr('readOnly', true)
                        $('#modal_novo_roles_users form select').attr('disabled', true)
                        $('#modal_novo_roles_users .modal-header').css('backgroundColor', '#ADB5BD')
                        $('#modal_novo_roles_users .modal-title').html('Roles Users | Vizualizar')
                        $('#modal_novo_roles_users .modal-footer input').hide()

                    })
                    //$('#modal_form_roles_users').trigger('reset')
                    $('#modal_novo_roles_users').modal('show')
                }

            })
        }

        function alterar_roles_usersView(id) {
            //$('#modal_form_roles_users').trigger('reset')
            $.get({
                url: 'roles_users/show',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (data) {
                    $('.id_roles_users').val(id)
                    Object.values(data).forEach(function (row) {

                        $('.roles_users_name').val(row.name)

                        $('#modal_novo_roles_users form input').attr('readOnly', false)
                        $('#modal_novo_roles_users form select').attr('disabled', false)
                        $('#modal_novo_roles_users .modal-header').css('backgroundColor', '#FFD600')
                        $('#modal_novo_roles_users .modal-title').html('Roles Users | Alterar')
                        $('#modal_novo_roles_users .modal-footer input').val('Alterar').show()

                    })
                    $('#modal_novo_roles_users').modal('show')
                }

            })
        }


    </script>

@endsection
