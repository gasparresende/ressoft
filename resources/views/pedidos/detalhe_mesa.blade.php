@extends('layouts.app')

<style>

    @media (min-width: 768px) {
        html {
            font-size: 16px;
        }
    }

    .container {
        max-width: 960px;
    }

    .pricing-header {
        max-width: 700px;
    }

    .card-deck .card {
        min-width: 220px;
    }

    .border-top {
        border-top: 1px solid #e5e5e5;
    }

    .border-bottom {
        border-bottom: 1px solid #e5e5e5;
    }

    .box-shadow {
        box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05);
    }

    #grid_produtos {
        text-align: center;

    }

    td, th {
        color: darkblue;
        font-weight: bold;
        text-align: left;
    }

</style>

@section('title', 'Shop')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-primary">Gestão de Pedido</h1>

        <div class="card shadow text-dark font-weight-bold mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Abrir Pedido</h6>


            </div>

            <div class="card-body" style="margin: 25px 25px">
                <form action=# method="post" id="pedidos_form">
                    @csrf

                    <a class="btn btn-info" href="{{route('pedidos.abrir')}}">Voltar</a>
                    <a class="btn btn-dark" href="#">Imprimir Consulta <i
                            class="fa fa-download"></i></a>
                    @if($pedido)
                        <a class="btn btn-success text-white" href="#">Finalizar Pedido <i
                                class="fa fa-check-double"></i></a>
                    @endif

                    <div class="card-body" id="grid_produtos" style="text-align: center">

                        <h2 class="text-info">Detalhe Mesa - {{$mesa->mesa}}</h2>
                        <div class="row w-50" style="margin: auto">
                            <div class="form-group col-md-12 mb-3">
                                <table class="table table-sm">
                                    <tr>
                                        <th>Status</th>
                                        <th>Garçon</th>
                                        <th>Cliente</th>
                                        <th>Data</th>
                                    </tr>
                                    <tr>
                                        <td>{{detalhes_mesas($mesa->id) ? detalhes_mesas($mesa->id)->statu : 'Disponível'}}</td>
                                        <td>{{detalhes_mesas($mesa->id) ? detalhes_mesas($mesa->id)->nome_garcon : ''}}</td>
                                        <td>{{detalhes_mesas($mesa->id) ? 'CONSUMIDOR FINAL' : ''}}</td>
                                        <td>{{detalhes_mesas($mesa->id) ? data_formatada(detalhes_mesas($mesa->id)->data, 'd-m-Y h:i:s'): ''}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if(detalhes_mesas($mesa->id))
                            @if(detalhes_mesas($mesa->id)->statu=='Ocupado')
                                <div class="row mt-4">
                                    <hr>
                                    @foreach($produtos as $produto)

                                        <div class="form-group col-md-3 mb-5"
                                             title="Stock: {{getStock_actual($produto->id, null, 1000, 1000, 5)}}">

                                            <h6>{{$produto->servicos}}</h6>

                                            <a href="#" data-toggle="modal"
                                               onclick="alterar_pedido({{$produto->id}}, {{$mesa->id}})">
                                                <img class="img-thumbnail w-50 h-75 click_imagem"
                                                     src="{{check_file_exist($produto->imagem)? asset("storage/$produto->imagem") : asset('img/sem_imagem.png')}}"
                                                     alt="">
                                            </a>
                                            <a style="display: block; margin: auto"
                                               onclick="vizualizar_detalhe_produto({{$produto->id}})"
                                               class="btn btn-sm btn-info mt-2 w-50" href="#" data-toggle="modal">Detalhes</a>


                                        </div>

                                    @endforeach
                                    <hr>
                                </div>
                                <h3 class="mt-2 text-success">Itens Selecionado - Pedido
                                    Nº {{$pedido ? $pedido->id : null}}</h3>
                                <div class="row w-100" style="margin: auto">
                                    <div class="form-group col-md-12 mb-3">
                                        <table class="table table-sm">
                                            <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Preço Un (kz)</th>
                                                <th>QTD</th>
                                                <th>Total</th>
                                                <th>Ações</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $total = 0;
                                            @endphp
                                            @foreach($pedidos as $pedido)
                                                @php
                                                    $total +=$pedido->valor * $pedido->qtd;
                                                @endphp
                                                <tr title="{{$pedido->descricao}}">
                                                    <td>{{$pedido->servicos}}</td>
                                                    <td>{{formatar_moeda($pedido->valor)}}</td>
                                                    <td>{{$pedido->qtd}}</td>
                                                    <td>{{formatar_moeda($pedido->qtd * $pedido->valor)}}</td>
                                                    <td>
                                                        <a title="Cancelar Pedido" class="btn btn-sm btn-danger text-white"
                                                           href="{{route('pedidos_servicos.delete', ['id'=>$pedido->pedidos_servicos_id])}}"><i
                                                                class="fa fa-ban"></i></a>
                                                        <a title="Imprimir Pedido" class="btn btn-sm btn-primary text-white"
                                                           href="#"><i class="fa fa-print"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td colspan="3">TOTAL</td>
                                                <td>{{formatar_moeda($total)}}</td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                            @else
                                <a class="btn btn-dark" data-toggle="modal" href="#modal_fechar_mesa">Fechar Mesa</a>

                            @endif
                        @else
                            <a class="btn btn-success" data-toggle="modal" href="#modal_abrir_mesa">Abrir Mesa</a>

                        @endif

                    </div>
                </form>
            </div>

            <div class="card-footer py-3">
                <span class="text-danger">(*) Campos Obrigatório</span>
            </div>

        </div>


    </div>

    <!-- Modal -->
    <div class="modal" tabindex="-1" role="dialog" id="abrir_mesa">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h4 class="modal-title text-center text-white">Abrir Mesa</h4>

                </div>
                <form action="{{route('mesas.abrir.store')}}" method="post" >
                    @csrf
                    <div class="modal-body">

                        <input type="hidden" name="origem_pedido" value="1">
                        <input type="hidden" name="mesas_id" value="" id="abrir_mesas_mesas_id">
                        <div class="row">

                            <div class="form-group col-md-12">
                                <label for="">Garçon</label>
                                <select required class="form-control form-control-sm" name="users_id">
                                    <option value="">-- select --</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->username}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Abrir </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- FIM Modal -->

@endsection

@section('js')

    <script>
        function abrir_mesa(id) {

            $('#abrir_mesas_mesas_id').val(id)
            $('#abrir_mesa').modal('show')
        }

        $(function () {

        })
    </script>

@endsection