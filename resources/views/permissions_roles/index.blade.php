@extends('layouts.app')

@section('title', 'Product')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Permissions - Roles</h1>

        <div class="text-left mb-2">
            <a class="btn btn-outline-primary" data-toggle="modal" href="#" id="btn_novo_permissions_roles">Novo</a>

        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listar Todos</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="permissions_roles">
                        <thead>
                        <tr>
                            <th scope="col">Role</th>
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
    <div id="modal_novo_permissions_roles" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Role - Permissions | Novo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('permissions_roles.store')}}" role="form" enctype="multipart/form-data"
                      method="post" id="modal_form_permissions_roles">
                    @csrf

                    <input hidden type="number" name="id" class="id_permissions_roles">
                    <div class="modal-body">

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="name">Roles *</label>
                                <select required class="form-control form-control-sm permissions_roles_roles_id" name="roles_id">
                                    <option value="">-- selecione a função --</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
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

            $('.permissions_roles_roles_id').change(function () {
                var res = ''
                $.get({
                    url: '{{route('permissions_roles.listar_by_id')}}',
                    dataType: 'json',
                    data: {
                        id: $('.permissions_roles_roles_id').val()
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

            $('#permissions_roles').dataTable({
                "order": [0, 'desc'],
                ajax: {
                    url: "{{route('permissions_roles.listar')}}",
                },
                columns: [
                    {data: 'funcao'},
                    {data: 'permissao'},
                    {
                        "render": function (data, type, row) {
                            return `<a title="Eliminar" onclick="eliminar('permissions_roles/delete?permission_id=${row.permission_id}&role_id=${row.role_id}')" class="btn btn-sm btn-danger m-1" href="#"> <i class="fas fa-trash-alt"></i></a>`
                        }
                    }
                ]
            })


            //Executar
            novo_roles_user()
        })


        /*Funções*/
        function novo_roles_user() {
            $('#btn_novo_permissions_roles').click(function () {
                $('.id_permissions_roles').attr('disabled', true)
                $('#modal_novo_permissions_roles form input').attr('readOnly', false)
                $('#modal_novo_permissions_roles form select').attr('disabled', false)
                $('#modal_novo_permissions_roles .modal-header').css('backgroundColor', '#11CDEF')
                $('#modal_novo_permissions_roles .modal-title').html('Roles - Permissions | Novo')
                $('#modal_novo_permissions_roles .modal-footer input').val('Salvar').show()
                $('#modal_form_permissions_roles').trigger('reset')

                $('#modal_novo_permissions_roles').modal('show')
            })
        }

        function visualizar_permissions_rolesView(id) {
            $.get({
                url: 'permissions_roles/show',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (data) {
                    $('.id_permissions_roles').val(id)
                    Object.values(data).forEach(function (row) {
                        $('.permissions_roles_name').val(row.name)

                        $('#modal_novo_permissions_roles form input').attr('readOnly', true)
                        $('#modal_novo_permissions_roles form select').attr('disabled', true)
                        $('#modal_novo_permissions_roles .modal-header').css('backgroundColor', '#ADB5BD')
                        $('#modal_novo_permissions_roles .modal-title').html('permissions_roles | Vizualizar')
                        $('#modal_novo_permissions_roles .modal-footer input').hide()

                    })
                    //$('#modal_form_permissions_roles').trigger('reset')
                    $('#modal_novo_permissions_roles').modal('show')
                }

            })
        }

        function alterar_permissions_rolesView(id) {
            //$('#modal_form_permissions_roles').trigger('reset')
            $.get({
                url: 'permissions_roles/show',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (data) {
                    $('.id_permissions_roles').val(id)
                    Object.values(data).forEach(function (row) {

                        $('.permissions_roles_name').val(row.name)

                        $('#modal_novo_permissions_roles form input').attr('readOnly', false)
                        $('#modal_novo_permissions_roles form select').attr('disabled', false)
                        $('#modal_novo_permissions_roles .modal-header').css('backgroundColor', '#FFD600')
                        $('#modal_novo_permissions_roles .modal-title').html('permissions_roles | Alterar')
                        $('#modal_novo_permissions_roles .modal-footer input').val('Alterar').show()

                    })
                    $('#modal_novo_permissions_roles').modal('show')
                }

            })
        }


    </script>

@endsection
