@extends('layouts.app')

@section('title', 'Product')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Permission - Users</h1>

        <div class="text-left mb-2">
            <a class="btn btn-outline-primary" data-toggle="modal" href="#" id="btn_novo_permission_users">Novo</a>

        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listar Todos</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="permission_users">
                        <thead>
                        <tr>
                            <th scope="col">Users</th>
                            <th scope="col">Permissão</th>
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
    <div id="modal_novo_permission_users" class="modal fade" tabindex="-1" users="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" users="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Users - Permissions | Novo</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('permission_users.store')}}" users="form" enctype="multipart/form-data"
                      method="post" id="modal_form_permission_users">
                    @csrf

                    <input hidden type="number" name="id" class="id_permission_users">
                    <div class="modal-body">

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="name">Users *</label>
                                <select required class="form-control form-control-sm permission_users_users_id" name="users_id">
                                    <option value="">-- selecione a função --</option>
                                    @foreach($users as $users)
                                        <option value="{{$users->id}}">{{$users->username}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-12">
                                <label for="name">Permission *</label>
                                <div class="res_permissions">

                                </div>

                            </div>

                        </div>


                    </div>
                    <div class="modal-footer" style="border-top: 1px #0da5c0 solid">
                        <input type="submit" class="btn btn-success" value="Salvar">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
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

            $('.permission_users_users_id').change(function () {
                var res = ''
                $.get({
                    url: '{{route('permission_users.listar_by_id')}}',
                    dataType: 'json',
                    data: {
                        id: $('.permission_users_users_id').val()
                    },
                    success: function (data) {
                        Object.values(data).forEach(function (row) {
                            res += `<div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="${row.id}" id="permission${row.id}" name="permission_id[]">
                                                <label class="form-check-label" for="permission${row.id}">
                                                    ${row.name}
                                                </label>
                                            </div>`
                        })
                        $('.res_permissions').html(res)
                    }

                })
            })

            $('#permission_users').dataTable({
                "order": [0, 'desc'],
                ajax: {
                    url: "{{route('permission_users.listar')}}",
                },
                columns: [
                    {data: 'username'},
                    {data: 'permissao'},
                    {
                        "render": function (data, type, row) {
                            return `<a title="Eliminar" onclick="eliminar('permission_users/delete?permission_id=${row.permission_id}&model_id=${row.model_id}')" class="btn btn-sm btn-danger m-1" href="#"> <i class="fas fa-trash-alt"></i></a>`
                        }
                    }
                ]
            })


            //Executar
            novo_users_user()
        })


        /*Funções*/
        function novo_users_user() {
            $('#btn_novo_permission_users').click(function () {
                $('.id_permission_users').attr('disabled', true)
                $('#modal_novo_permission_users form input').attr('readOnly', false)
                $('#modal_novo_permission_users form select').attr('disabled', false)
                $('#modal_novo_permission_users .modal-header').css('backgroundColor', '#11CDEF')
                $('#modal_novo_permission_users .modal-title').html('Users - Permissions | Novo')
                $('#modal_novo_permission_users .modal-footer input').val('Salvar').show()
                $('#modal_form_permission_users').trigger('reset')

                $('#modal_novo_permission_users').modal('show')
            })
        }

        function visualizar_permission_usersView(id) {
            $.get({
                url: 'permission_users/show',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (data) {
                    $('.id_permission_users').val(id)
                    Object.values(data).forEach(function (row) {
                        $('.permission_users_name').val(row.name)

                        $('#modal_novo_permission_users form input').attr('readOnly', true)
                        $('#modal_novo_permission_users form select').attr('disabled', true)
                        $('#modal_novo_permission_users .modal-header').css('backgroundColor', '#ADB5BD')
                        $('#modal_novo_permission_users .modal-title').html('permission_users | Vizualizar')
                        $('#modal_novo_permission_users .modal-footer input').hide()

                    })
                    //$('#modal_form_permission_users').trigger('reset')
                    $('#modal_novo_permission_users').modal('show')
                }

            })
        }

        function alterar_permission_usersView(id) {
            //$('#modal_form_permission_users').trigger('reset')
            $.get({
                url: 'permission_users/show',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (data) {
                    $('.id_permission_users').val(id)
                    Object.values(data).forEach(function (row) {

                        $('.permission_users_name').val(row.name)

                        $('#modal_novo_permission_users form input').attr('readOnly', false)
                        $('#modal_novo_permission_users form select').attr('disabled', false)
                        $('#modal_novo_permission_users .modal-header').css('backgroundColor', '#FFD600')
                        $('#modal_novo_permission_users .modal-title').html('permission_users | Alterar')
                        $('#modal_novo_permission_users .modal-footer input').val('Alterar').show()

                    })
                    $('#modal_novo_permission_users').modal('show')
                }

            })
        }


    </script>

@endsection
