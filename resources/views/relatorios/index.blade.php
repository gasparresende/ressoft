@extends('layouts.app')

@section('title', 'Product')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Gestão de Relatórios</h1>

        <div class="text-left mb-2">
            <a class="btn btn-dark" href="{{route('relatorios.cardapio')}}">Cardápio Digital <i
                    class="fa fa-history"></i></a>
            <a class="btn btn-dark" id="click_relatorio_vendas" href="#">Vendas<i class="fa fa-cart-plus"></i></a>
            <a class="btn btn-dark" id="click_relatorio_caixas" href="#">Caixa<i class="fa fa-cart-plus"></i></a>

        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listar Todos</h6>
            </div>
            <div class="card-body">

                <div id="relatorio_vendas" >
                    <h4 class="mb-3 text-primary">Relatório de Venda</h4>

                    <form action="{{route('relatorios.vendas')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Utilizador</label>
                                <select name="users_id" id="" class="form-control">
                                    <option value="">Selecione</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->username}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="">Loja</label>
                                <select name="shops_id" id="" class="form-control">
                                    <option value="">Selecione</option>
                                    @foreach($lojas as $loja)
                                        <option value="{{$loja->id}}">{{$loja->loja}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="">Data Inicial</label>
                                <input required  value="{{data_formatada(now(), 'Y-m-d')}}" name="data1" type="date" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label for="">Data Final</label>
                                <input required name="data2"  value="{{data_formatada(now(), 'Y-m-d')}}"  type="date" class="form-control">
                            </div>
                        </div>
                        <div class="mt-3 text-right">
                            <input class="btn btn-dark" type="submit" value="Gerar Relatório">

                        </div>
                    </form>

                </div>

                <div id="relatorio_caixas" >
                    <h4 class="mb-3 text-primary">Relatório de Caixa</h4>


                    <form action="{{route('relatorios.caixas')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Utilizador</label>
                                <select name="users_id" id="" class="form-control">
                                    <option value="">Selecione</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->username}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="">Loja</label>
                                <select name="shops_id" id="" class="form-control">
                                    <option value="">Selecione</option>
                                    @foreach($lojas as $loja)
                                        <option value="{{$loja->id}}">{{$loja->loja}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="">Data Inicial</label>
                                <input required  value="{{data_formatada(now(), 'Y-m-d')}}" name="data1" type="date" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label for="">Data Final</label>
                                <input required name="data2"  value="{{data_formatada(now(), 'Y-m-d')}}"  type="date" class="form-control">
                            </div>
                        </div>
                        <div class="mt-3 text-right">
                            <input class="btn btn-dark" type="submit" value="Gerar Relatório">

                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

@endsection

@section('js')

    <script>
        $(function () {

            $('#relatorio_vendas').hide();
            $('#relatorio_caixas').hide();


            $('#click_relatorio_vendas').click(function () {
                $('#relatorio_caixas').hide();
                $('#relatorio_vendas').show();
            })


            $('#click_relatorio_caixas').click(function () {
                $('#relatorio_vendas').hide();
                $('#relatorio_caixas').show();
            })
        })
    </script>

@endsection
