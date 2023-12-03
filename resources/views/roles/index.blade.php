@extends('layouts.app')

@section('title', 'Product')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Gestão de Roles</h1>

        <div class="text-left mb-2">
            <a class="btn btn-outline-primary" data-toggle="modal" href="#" id="btn_novo_roles">Novo</a>

        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listar Todos</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-striped" id="roles">
                        <thead>
                        <tr>
                            <th scope="col" class="sort" data-sort="name">ID</th>
                            <th scope="col" class="sort" data-sort="name">Role</th>
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
    <div id="modal_novo_roles" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">roles | Novo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('roles.store')}}" role="form" enctype="multipart/form-data" method="post" id="modal_form_roles">
                    @csrf

                    <input hidden type="number" name="id" class="id_roles">
                    <div class="modal-body">

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="name">Nome *</label>
                                <input required autofocus class="form-control form-control-sm roles_name" type="text" name="name">
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

            $('#roles').dataTable({
                "order": [0, 'desc'],
                ajax: {
                    url: "{{route('roles.listar')}}",
                },
                columns: [
                    {data: 'id'},
                    {data: 'name'},
                    {
                        "render": function (data, type, row) {
                            return `<a title="Vizualizar" onclick="visualizar_rolesView(${row.id})" class="btn btn-sm btn-info m-1" href="#"> <i class="fas fa-eye"></i> </a>` +
                                `<a title="Eliminar" onclick="eliminar('roles/delete?id=${row.id}')" class="btn btn-sm btn-danger m-1" href="#"> <i class="fas fa-trash-alt"></i></a>` +
                                `<a title="Alterar" onclick="alterar_rolesView(${row.id})" class="btn btn-sm btn-success m-1" href="#"> <i class="fas fa-edit"></i></a>`
                        }
                    }
                ]
            })


            //Executar
            novo_role()
        })


        /*Funções*/
        function novo_role() {
            $('#btn_novo_roles').click(function () {
                $('.id_roles').attr('disabled', true)
                $('#modal_novo_roles form input').attr('readOnly', false)
                $('#modal_novo_roles form select').attr('disabled', false)
                $('#modal_novo_roles .modal-header').css('backgroundColor', '#11CDEF')
                $('#modal_novo_roles .modal-title').html('Roles | Novo')
                $('#modal_novo_roles .modal-footer input').val('Salvar').show()
                $('#modal_form_roles').trigger('reset')

                $('#modal_novo_roles').modal('show')
            })
        }

        function visualizar_rolesView(id) {
            $.get({
                url: 'roles/show',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (data) {
                    $('.id_roles').val(id)
                    Object.values(data).forEach(function (row) {
                        $('.roles_name').val(row.name)

                        $('#modal_novo_roles form input').attr('readOnly', true)
                        $('#modal_novo_roles form select').attr('disabled', true)
                        $('#modal_novo_roles .modal-header').css('backgroundColor', '#ADB5BD')
                        $('#modal_novo_roles .modal-title').html('Roles | Vizualizar')
                        $('#modal_novo_roles .modal-footer input').hide()

                    })
                    //$('#modal_form_roles').trigger('reset')
                    $('#modal_novo_roles').modal('show')
                }

            })
        }

        function alterar_rolesView(id) {
            //$('#modal_form_roles').trigger('reset')
            $.get({
                url: 'roles/show',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (data) {
                    $('.id_roles').val(id)
                    Object.values(data).forEach(function (row) {

                        $('.roles_name').val(row.name)

                        $('#modal_novo_roles form input').attr('readOnly', false)
                        $('#modal_novo_roles form select').attr('disabled', false)
                        $('#modal_novo_roles .modal-header').css('backgroundColor', '#FFD600')
                        $('#modal_novo_roles .modal-title').html('Roles | Alterar')
                        $('#modal_novo_roles .modal-footer input').val('Alterar').show()

                    })
                    $('#modal_novo_roles').modal('show')
                }

            })
        }


    </script>

@endsection
