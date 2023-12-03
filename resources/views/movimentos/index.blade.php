@extends('layouts.app')

@section('title', 'Product')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Gestão de Fluxo Financeiro</h1>

        <div class="text-left mb-2">
            <a class="btn btn-sm btn-primary"  href="{{route('movimentos.create')}}"
               id="">Novo</a>

            <a href="{{route('movimentos.create-especifico')}}" class="btn btn-sm btn-primary">Nota Débito / Crédito</a>

            <a href="#" class="btn btn-sm btn-success" data-toggle="modal"
               data-target="#movimentos_exportar"
               id="btn_novo_roles">Exportar Excel<i class="fa fa-file-excel-o"></i> </a>

        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listar Todos</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">

                    <form action="">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <input class="form-control form-control-sm-sm min" type="date" name="min">
                            </div>
                            <div class="form-group col-md-2">
                                <input class="form-control form-control-sm-sm max" type="date" name="max">
                            </div>
                        </div>
                    </form>


                    <table class="table table-sm table-striped" id="movimentos" style="font-size: 9pt">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Data do Movimento</th>
                            <th>Data da Operação</th>
                            <th>Contas</th>
                            <th>Débito</th>
                            <th>Crédito</th>
                            <th>Descrição</th>
                        </tr>
                        </thead>

                        <tbody>

                        </tbody>

                    </table>
                </div>
            </div>

        </div>

    </div>

    <!-- Modal -->
    <div id="modal_novo_movimentos" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Movimentos | Novo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('movimentos.store')}}" role="form" enctype="multipart/form-data"
                      method="post" id="modal_form_movimentos">
                    @csrf

                    <input hidden type="number" name="id" class="id_movimentos">
                    <div class="modal-body">

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">Contas (Débito) *</label>
                                <select required class="form-control form-control-sm" name="debito">
                                    <option value="">-- selecione uma conta --</option>
                                    @foreach($contas as $row)
                                        <option value="{{$row->id}}">{{$row->conta}}
                                            - {{$row->descricao}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Contas (Cédito) *</label>
                                <select required class="form-control form-control-sm" name="credito">
                                    <option value="">-- selecione uma conta --</option>
                                    @foreach($contas as $row)
                                        <option value="{{$row->id}}">{{$row->conta}}
                                            - {{$row->descricao}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">Descrição *</label>
                                <input required class="form-control form-control-sm" type="text"
                                       name="movimentos">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Valor *</label>
                                <input required class="form-control form-control-sm dinheiro" type="text"
                                       name="valor">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Data Movimento *</label>
                                <input required class="form-control form-control-sm desbloquear_movimentos"
                                       type="date"
                                       min="{{data_formatada(now(), 'Y-01')}}-01"
                                       max="{{data_formatada(now(), 'Y-m-d')}}" name="data_movimento">
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

    <div id="modal_novo_nota_debito" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Movimentos | Novo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('movimentos.store2')}}" role="form" enctype="multipart/form-data"
                      method="post" id="modal_form_nota_debito">
                    @csrf

                    <input hidden type="number" name="id" class="id_movimentos">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">Contas *</label>
                                <select required class="form-control form-control-sm" name="contas">
                                    <option value="">-- selecione uma conta --</option>
                                    @foreach($contas as $row)
                                        <option value="{{$row->id}}">{{$row->conta}}
                                            - {{$row->descricao}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Tipo Movimento *</label>
                                <select required class="form-control form-control-sm" name="tipo">
                                    <option value="">-- selecione uma opção --</option>
                                    <option value="1">Débito</option>
                                    <option value="2">Crédito</option>

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">Descrição *</label>
                                <input required class="form-control form-control-sm" type="text"
                                       name="movimentos">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Valor *</label>
                                <input required class="form-control form-control-sm dinheiro" type="text"
                                       name="valor">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Data Movimento *</label>
                                <input required class="form-control form-control-sm" type="date"
                                       name="data_movimento">
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

    <div class="modal" tabindex="-1" role="dialog" id="movimentos_exportar">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h3 class="modal-title text-center text-white">Exportar Extracto de Movimento</h3>

                </div>
                <form action="{{route('excel.exportar-movimentos')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="">Contas</label>
                                <select class="form-control form-control-sm" name="contas_id">
                                    <option value="%">-- selecione uma conta --</option>
                                    @foreach($contas as $row)
                                        <option value="{{$row->id}}">{{$row->conta}}
                                            - {{$row->descricao}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">Data Início</label>
                                <input class="form-control form-control-sm" type="date" name="data_inicio">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Data Final</label>
                                <input class="form-control form-control-sm" type="date" name="data_final">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Exportar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <div id="modal_alterar_movimentos" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">movimentos | Novo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('movimentos.store')}}" role="form" enctype="multipart/form-data"
                      method="post" id="modal_form_movimentos">
                    @csrf
                    <input type="hidden" name="id" class="id_movimentos">
                    <input type="hidden" name="tipo" class="movimentos_tipo">
                    <div class="modal-body">

                        <div class="row">
                            <div class="form-group col-md-9">
                                <label for="">Contas *</label>
                                <select required class="form-control form-control-sm debito" name="debito">
                                    <option value="">-- selecione uma conta --</option>
                                    @foreach($contas as $row)
                                        <option value="{{$row->id}}">{{$row->conta}}
                                            - {{$row->descricao}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Valor <span id="label_valor"></span> *</label>
                                <input required class="form-control form-control-sm dinheiro valor"
                                       type="text"
                                       name="valor">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-9">
                                <label for="">Descrição *</label>
                                <input required class="form-control form-control-sm movimentos" type="text"
                                       name="movimentos">
                            </div>
                            {{--<div class="form-group col-md-3">
                                <label for="">Valor *</label>
                                <input required class="form-control form-control-sm dinheiro valor" type="text"
                                       name="valor">
                            </div>--}}
                            <div class="form-group col-md-3">
                                <label for="">Data Movimento *</label>
                                <input required
                                       class="form-control form-control-sm data_movimento desbloquear_movimentos"
                                       type="date"
                                       min="{{data_formatada(now(), 'Y-m')}}-01"
                                       max="{{data_formatada(now(), 'Y-m-d')}}" name="data_movimento">
                            </div>
                        </div>

                        <div class="row">
                            <div class="row mt-5" style="margin-left: 8px">
                                <div class="form-group col-md-6">
                                    <p>(*) Campos Obrigatório</p>
                                    @can('acessos')
                                        <button class="btn-sm btn-warning desbloquear_datas">Debloquear
                                            Datas
                                        </button>
                                    @endcan
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

@endsection

@section('js')

    <script>


        //Funções
        function formatarData(str) {
            var partes = str.split('-');
            return partes[2] + '-' + partes[1] + '-' + partes[0]
        }

        function alterar_movimentosView(id) {
            //$('#modal_form_movimentos').trigger('reset')
            $.ajax({
                url: 'movimentos/show',
                type: "get",
                data: {
                    id: id
                },
                dataType: "json",
                success: function (data) {
                    $('.id_movimentos').val(id)
                    Object.values(data).forEach(function (row) {

                        $('.debito').val(row.contas_id)
                        //$('.credito').val(row.contas_id)
                        $('.movimentos').val(row.movimentos)
                        if (row.debito > 0) {
                            $('.valor').val(moeda(row.debito))
                            $('#label_valor').text('Débito')
                            $('.movimentos_tipo').val('D')
                        } else {
                            $('.valor').val(moeda(row.credito))
                            $('#label_valor').text('Crédito')
                            $('.movimentos_tipo').val('C')
                        }

                        $('.data_movimento').val(row.data_movimento)
                        $('#modal_alterar_movimentos form input').attr('readOnly', false)
                        $('#modal_alterar_movimentos form select').attr('disabled', false)
                        $('#modal_alterar_movimentos .modal-header').css('backgroundColor', '#FFD600')
                        $('#modal_alterar_movimentos .modal-title').html('Movimentos | Alterar')
                        $('#modal_alterar_movimentos .modal-footer input').val('Alterar').show()

                    })
                    $('#modal_alterar_movimentos').modal('show')
                }
            })
        }

        /*Funções*/
        function novo_movimentos() {
            $('#btn_novo_movimentos').click(function () {
                $('.id_movimentos').attr('disabled', true)
                $('#modal_novo_movimentos form input').attr('readOnly', false)
                $('#modal_novo_movimentos form select').attr('disabled', false)
                $('#modal_novo_movimentos .modal-header').css('backgroundColor', '#11CDEF')
                $('#modal_novo_movimentos .modal-title').html('Movimentos | Novo')
                $('#modal_novo_movimentos .modal-footer input').val('Salvar').show()
                $('#modal_form_movimentos').trigger('reset')

                $('#modal_novo_movimentos').modal('show')
            })
        }

        function novo_nota_debito() {
            $('#btn_novo_nota_debito').click(function () {
                $('.id_movimentos').attr('disabled', true)
                $('#modal_novo_nota_debito form input').attr('readOnly', false)
                $('#modal_novo_nota_debito form select').attr('disabled', false)
                $('#modal_novo_nota_debito .modal-header').css('backgroundColor', '#11CDEF')
                $('#modal_novo_nota_debito .modal-title').html('Movimentos | Novo')
                $('#modal_novo_nota_debito .modal-footer input').val('Salvar').show()
                $('#modal_form_nota_debito').trigger('reset')

                $('#modal_novo_nota_debito').modal('show')
            })
        }

        function visualizar_movimentosView(id) {
            $.get({
                url: 'movimentos/show',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (data) {
                    $('.id_movimentos').val(id)
                    Object.values(data).forEach(function (row) {
                        $('.movimentos_nome').val(row.nome)
                        $('.movimentos_nif').val(row.nif)
                        $('.movimentos_telemovel').val(row.telemovel)
                        $('.movimentos_email').val(row.email)
                        $('.movimentos_endereco').val(row.endereco)
                        $('.movimentos_contas_id').val(row.contas_id)

                        $('#modal_novo_movimentos2 form input').attr('readOnly', true)
                        $('#modal_novo_movimentos2 form select').attr('disabled', true)
                        $('#modal_novo_movimentos2 .modal-header').css('backgroundColor', '#ADB5BD')
                        $('#modal_novo_movimentos2 .modal-title').html('movimentos | Vizualizar')
                        $('#modal_novo_movimentos2 .modal-footer input').hide()

                    })
                    //$('#modal_form_movimentos').trigger('reset')
                    $('#modal_novo_movimentos2').modal('show')
                }

            })
        }

        $(function () {

            novo_movimentos()
            novo_nota_debito()
            var movimentos = $('#movimentos').dataTable({
                'order': [0, 'desc'],
                "processing": true,
                'destroy': true,
                //Sync
                "language": {
                    "processing": '<i class="fa fa-spinner fa-spin fa-6x" style="font-size:50px;color:darkblue;"></i>'
                },
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "autoWidth": true,

                ajax: {
                    url: "{{route('movimentos.listar')}}",
                },
                columns: [
                    {data: 'id'},
                    {data: 'data_movimento'},
                    {data: 'data_operacao'},
                    {data: 'contas'},
                    {data: 'debito'},
                    {data: 'credito'},
                    {data: 'razao'},


                ],


            })

            $('.min, .max').change(function () {
                $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        var min = $(".min").val()
                        var max = $(".max").val()


                        var startDate = formatarData(data[1]) || 0; // Our date column in the table

                        if (min == '' && max == '') {
                            return true;
                        }
                        if (min == null && startDate <= max) {
                            return true;
                        }
                        if (max == null && startDate >= min) {
                            return true;
                        }
                        if (startDate <= max && startDate >= min) {
                            return true;
                        }
                        return false;
                    }
                )

                movimentos.fnFilter();
            });

        })


    </script>

@endsection
