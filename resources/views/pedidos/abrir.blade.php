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

    #grid_mesas {
        text-align: center;

    }

    #listagem_mesas {
        border: 1px solid blue;
        height: 150px;
        margin-right: 10px;
        padding-top: 10px;
        box-shadow: 15px 10px 10px blue;

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

            <div class="card-body">
                <form action="{{route('pedidos.abrir.store')}}" method="post">
                    @csrf


                    <h2>Pedidos por Mesas</h2>

                    <div class="row mt-4 mx-auto">
                        @foreach($mesas as $mesa)

                            <div class="form-group col-md-2 mb-2 img-thumbnail" id="listagem_mesas">
                                <h6>Mesa - {{$mesa->mesa}}</h6>

                                @if(status_mesa($mesa->id) == 'Disponível')
                                    <p class="text-success"
                                       style="font-weight: bold">{{status_mesa($mesa->id)}}</p>

                                @elseif(status_mesa($mesa->id) == 'Reservado')
                                    <p class="text-info"
                                       style="font-weight: bold">{{status_mesa($mesa->id)}}</p>

                                @else
                                    <p class="text-danger"
                                       style="font-weight: bold">{{status_mesa($mesa->id)}} | {{garcon($mesa->id)}}</p>

                                @endif

                                <div>

                                    @if(status_mesa($mesa->id) == 'Disponível')
                                        <a class="btn btn-sm btn-success" data-toggle="modal"
                                           onclick="abrir_mesa({{$mesa->id}})" href="#"> Abrir </a>

                                    @elseif(status_mesa($mesa->id) == 'Fechado')
                                        <a class="btn btn-sm btn-success" data-toggle="modal"
                                           onclick="abrir_mesa({{$mesa->id}})" href="#"> Abrir </a>

                                    @elseif(status_mesa($mesa->id) == 'Reservado')
                                        <a class="btn btn-sm btn-success" data-toggle="modal"
                                           onclick="abrir_mesa({{$mesa->id}})" href="#"> Abrir </a>

                                    @else
                                        <a class="btn btn-sm btn-info"
                                           href="{{route('pedidos.mesas.detalhe', $mesa->id)}}"> Detalhe</a>
                                        <a class="btn btn-sm btn-primary"
                                           href="{{route('pedidos.mesas.consumo', $mesa->id)}}"> Consusmo</a>

                                    @endif

                                </div>
                            </div>

                        @endforeach
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
