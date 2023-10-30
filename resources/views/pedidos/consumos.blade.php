@extends('layouts.app')

<style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }

    .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
    }

    .bi {
        vertical-align: -.125em;
        fill: currentColor;
    }

    .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
    }

    .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
    }

    .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

    }

    .bd-mode-toggle {
        z-index: 1500;
    }

    .bd-mode-toggle .dropdown-menu .active .bi {
        display: block !important;
    }
</style>

@section('title', 'Shop')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-primary">Consumos da Mesa - Nº {{$mesa->id}}</h1>


        <div class="card shadow text-dark font-weight-bold mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Novo Consumo</h6>


            </div>

            <div class="card-body">

                <div class="container">

                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">

                        <!-- Inicio Card -->
                        @foreach($produtos as $produto)

                            <form action="/pedidos/adicionar/{{$mesa->id}}/cart" method="post">
                                @csrf
                                <div class="col">
                                    <div class="card shadow-sm">
                                        <div style="font-size: 10pt"
                                             class="card-header">{{$produto->products->product}}</div>

                                        <button type="submit">
                                            <img src="/storage/{{$produto->products->imagem}}"
                                                 class="bd-placeholder-img card-img-top" width="100%" height="150"/>

                                        </button>
                                        <div class="card-body">
                                            <p style="font-size: 8pt" class="card-text text-primary">
                                                Stock: {{$produto->qtd}}</p>
                                            <div class="d-flex justify-content-between align-items-center">


                                                <input type="hidden" name="inventories_id" value="{{$produto->id}}">
                                                <div class="input-group flex-wrap ">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">
                                                        Detalhes
                                                    </button>

                                                    <input class="form-control form-control-sm" name="qtd"
                                                           type="number" value="1">
                                                    <button class="btn btn-sm btn-outline-success" type="submit">
                                                        Adicionar
                                                    </button>
                                                    {{--
                                                    <a href="{{route('pedidos.adicionar.cart', ['mesa'=>$mesa, 'inventory'=>$produto->id])}}" class="btn btn-sm btn-outline-success">
                                                        Adicionar
                                                    </a>
                                                    --}}

                                                </div>




                                            </div>
                                            <div class="form-row mt-2">
                                                <div class="form-group col-md-12">
                                                    <label for="">Para Cozinha </label>
                                                    <div class="form-control">
                                                        <div class="form-check form-check-inline">
                                                            <input checked class="form-check-input" type="radio" name="cozinha"
                                                                   id="inlineRadio1" value="0">
                                                            <label class="form-check-label" for="inlineRadio1">Não</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="cozinha" id="inlineRadio2"
                                                                   value="1">
                                                            <label class="form-check-label" for="inlineRadio2">Sim</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <input placeholder="Observação" class="form-control form-control-sm" name="obs"
                                                           type="text" value="">
                                                </div>


                                            </div>


                                        </div>
                                    </div>
                                </div>

                            </form>
                        @endforeach


                    </div>
                </div>

                @if(session('carrinho_pedidos'))
                    <div class="container mt-3">
                        <h4 style="border: 1px solid black" class="text-center py-2">Produtos adicionado</h4>

                        <div class="text-right">
                            <a class="btn btn-danger mb-3" href="{{route('pedidos.cart.remover.all')}}"> Remover
                                todos
                            </a>

                        </div>
                        <table class="table table-sm table-striped tabela">
                            <thead>
                            <tr>
                                <th>Mesa</th>
                                <th>Produto</th>
                                <th>Qth</th>
                                <th>Preço</th>
                                <th>Total</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach(session('carrinho_pedidos') as $key => $cart)
                                <tr>
                                    <td>{{$cart['mesa']}}</td>
                                    <td>{{$cart['product']}}</td>
                                    <td>{{$cart['qtd']}}</td>
                                    <td>{{formatar_moeda($cart['preco'])}}</td>
                                    <td>{{formatar_moeda($cart['qtd'] * $cart['preco'])}}</td>
                                    <td>
                                        <a href="{{route('pedidos.cart.remover', ['id'=>$key])}}"
                                           class="btn btn-sm btn-outline-danger">
                                            <i class="fa fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>

                        <div class="text-right mt-3">
                            <form action="{{route('pedidos.store')}}" method="post">
                                @csrf
                                <button class="btn btn-success mb-3" type="submit"> Registar
                                    Pedido
                                </button>
                            </form>

                        </div>
                    </div>
                @endif


                <div class="mt-3">
                    <a class="btn btn-info" href="{{route('pedidos.abrir')}}"> Voltar</a>
                </div>
            </div>


            <div class="card-footer py-3">
                <span class="text-danger">(*) Campos Obrigatório</span>
            </div>

        </div>


    </div>

@endsection

@section('js')

    <script>


        $(function () {

        })
    </script>

@endsection
