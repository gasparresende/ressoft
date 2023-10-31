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

                    <a class="btn btn-primary" href="{{route('pedidos.abrir')}}">Voltar</a>

                    @if(detalhes_mesas($mesa->id))
                        @if($pedidos)
                            <a class="btn btn-dark" href="#">Imprimir Consulta <i
                                    class="fa fa-download"></i></a>

                        @else
                            <a class="btn btn-dark" data-toggle="modal" href="#modal_fechar_mesa">FecharMesa</a>

                        @endif

                    @endif


                    <div class="card-body" id="grid_produtos" style="text-align: center">

                        <h3 style="border: 1px solid #919090" class="text-primary">Detalhe Mesa - {{$mesa->mesa}}</h3>
                        <div class="row" style="margin: auto">
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

                            @if($pedidos->isNotEmpty())
                                <div class="row mb-5">
                                    <table class="tabel table-sm table-striped tabela">
                                        <thead>
                                        <tr>
                                            <th>Produto</th>
                                            <th>Qtd</th>
                                            <th>Preço</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($pedidos as $pedido)
                                            <tr title="{{$pedido->obs}}">
                                                <td>{{$pedido->product}}</td>
                                                <td>{{$pedido->qtd}}</td>
                                                <td>{{formatar_moeda($pedido->preco)}}</td>
                                                <td>{{$pedido->statu}}</td>
                                                <td>{{formatar_moeda($pedido->preco * $pedido->qtd)}}</td>
                                            </tr>
                                        @endforeach
                                        <tfoot>
                                        <tr>
                                            <th colspan="4">Total</th>
                                            <th>{{$total}}</th>
                                        </tr>
                                        </tfoot>

                                        </tbody>
                                    </table>
                                </div>
                            @endif

                        </div>


                        @if($pedido)
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h4 style="border: 1px solid black; border-radius: 5px" class="py-1 bg-gradient-primary text-white" >Meios de Pagamento</h4>
                                        <div class="row mb-2">
                                           <div class="col-md-6">
                                               <label for="">Cash</label>
                                               <input autofocus class="form-control dinheiro" type="text" value="">
                                           </div>
                                           <div class="col-md-6">
                                               <label for="">TPA</label>
                                               <input class="form-control dinheiro" type="text" value="">
                                           </div>
                                       </div>

                                        <div class="row">

                                            <div class="col-md-6 text-left">

                                                <button class="btn btn-success" type="submit"> Finalizar Pedido / Mesa <i
                                                        class="fa fa-check-double"></i></button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>


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
                <form action="{{route('mesas.abrir.store')}}" method="post">
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
                        <button type="submit" class="btn btn-success">Abrir</button>
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
