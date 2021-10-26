@extends('layouts.app')

@section('title', 'sele')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-primary">Vendas - Cadastro</h1>

        <div class="card shadow text-dark font-weight-bold mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Novo Registro</h6>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="card-body">
                <form action="{{route('carrinho.adicionar')}}" method="post">
                    @csrf

                    <div class="row mb-4">
                        <div class="form-group col-md-6">
                            <label for="">Produtos | Serviços</label>
                            <div class="input-group mb-3">
                                <input autofocus type="text" class="form-control nome_produto_pesquisa"
                                       placeholder="Código de Barrra | Nome do produto à pesquisar" name="codigo"
                                       aria-label="Recipient's username" aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary produtos_search" data-toggle="modal" type="button">
                                        Search
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="">QTD</label>
                            <input required type="number" class="form-control" placeholder="Quantidade" name="qtd"
                                   value="1">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Desconto</label>
                            <input name="desc" type="number" class="form-control" max="100" min="0"
                                   placeholder="Desconto (%)">
                        </div>

                        <div class="form-group col-md-2">
                            <button hidden type="submit" class="btn btn-primary">+</button>
                        </div>

                    </div>


                </form>

                <!-- Resultdado do carrinho -->
                <table class="table table-sm table-striped mt-3 table-produtos">
                    <thead>
                    <tr>
                        <th style="max-width: 600px;">Serviço</th>
                        <th>Quantidade</th>
                        <th>Desc (%)</th>
                        <th class="text-right pr-5">Valor (kz)</th>
                        <th class="text-right pr-5 vlTotalProduto">Total (kz)</th>
                        <th class="text-center">Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @if(session('carrinho'))
                        @foreach(session('carrinho') as $key => $cart)
                            @php
                                $valor_desc = ($cart['preco_venda'] - ($cart['preco_venda']*($cart['desc']/100))) *$cart['qtd'];
                                    $total += $valor_desc;

                            @endphp
                            <tr>
                                <td style="max-widtd: 600px;">{{$cart['produto']}}</td>
                                <td>{{$cart['qtd']}}</td>
                                <td>{{$cart['desc']}}</td>
                                <td class="text-right pr-5">{{number_format($cart['preco_venda'], '2', ',', '.')}}</td>
                                <td class="text-right pr-5 vlTotalProduto">{{number_format($valor_desc, '2', ',', '.')}}</td>
                                <td class="text-center"><a class="btn btn-danger"
                                                           href="{{route('carrinho.remover', $key)}}">remover</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                    <tfoot class="">
                    @if(session('carrinho'))
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="text-right">SubTotal ❯</th>
                            <th class="text-right pr-5"
                                id="vlTotalPedido">{{number_format($total, '2', ',', '.')}}</th>
                            <th></th>
                        </tr>
                        <a class="btn btn-success"
                           href="{{route('seles.next')}}">Próximo >></a>

                        <a class="btn btn-danger" style="margin-left: 5px"
                           href="{{route('carrinho.remover.todos')}}">Remover Todos</a>
                    @endif

                    <a class="btn btn-primary" style="margin-left: 5px"
                       href="{{route('seles.index')}}"><< Voltar</a>
                    </tfoot>
                </table>
            </div>

            <div class="card-footer py-3">
                <span class="text-danger">(*) Campos Obrigatório</span>
            </div>

        </div>


    </div>
    <!-- /.container-fluid -->

    <div class="modal modal_pesquisa_produtos" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Pesquisa de Productos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table style="width: 100%" class="table-sm table-striped tabela_simples">
                        <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>QTD</th>
                            <th>Preço</th>
                        </tr>
                        </thead>
                        <tbody class="vendas_pesquisas">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script>

        $(function () {

            var res = ''
            $('.produtos_search').click(function () {
                $.get({
                    url: '{{route('url.produtos_by_nome')}}',
                    dataType: 'json',
                    data: {
                        produto: $('.nome_produto_pesquisa').val(),
                    },
                    success: function (data) {

                        Object.values(data).forEach(function (row) {
                            res += `
                                <a href="{{route('carrinho.adicionar')}}?id=${row.id}">
                                    <tr>
                                        <td>${row.codigo}</td>
                                        <td>${row.produto}</td>
                                        <td>${row.qtd}</td>
                                        <td>${row.preco_venda}</td>
                                    </tr>
                                </<a>
                            `
                        })
                        $('.vendas_pesquisas').html(res)
                        $('.modal_pesquisa_produtos').modal('show')
                    }
                })
            })


        })
    </script>

@endsection
