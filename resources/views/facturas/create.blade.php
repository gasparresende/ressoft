@extends('layouts.app')

@section('title', 'Shop')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-primary">Lojas - Cadastro</h1>

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

                <form action="{{route('carrinho.compra.adicionar')}}" method="post" id="form_facturas">
                    @csrf

                    <div class="row mb-3">
                        {{--Filtros--}}
                        <div class="col-md-3 m-1">
                            <label class="" for="filtros_shops">shops (Opcional)</label>
                            <select id="filtros_shops" class="form-control form-control-sm filtros_shops"
                                    name="">
                                <option value="0">All</option>
                                @foreach($shops as $shop)
                                    <option value="{{$shop->id}}">{{$shop->loja}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label class="" for="filtros_descricao">Search by name</label>
                            <input id="filtros_descricao"
                                   placeholder="Pesquisar pela descrição do Produto / Serviço"
                                   class="form-control form-control-sm filtros_descricao" type="text">
                        </div>
                        <div class="col-md-5">
                            <label for="listar_inventories">Serviços | Produtos</label>
                            <select required class="form-control form-control-sm listar_inventories" id=""
                                    name="id">
                                <option value="">-- selecione um item --</option>
                                @foreach($inventories as $row)
                                    <option value="{{$row->id}}">{{$row->products->product}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-md-1">
                            <label for="form_facturas_quantidade">QTD</label>
                            <input id="form_facturas_quantidade" required type="number"
                                   class="form-control form-control-sm" placeholder="Quantidade"
                                   name="qtd" value="1">
                        </div>
                        <div class="col-md-2">
                            <label class="" for="form_facturas_desconto">Desconto</label>
                            <input id="form_facturas_desconto" name="desc" type="number"
                                   class="form-control form-control-sm" max="100" min="0"
                                   placeholder="Desconto (%)">
                        </div>
                        <div class="col-md-2">
                            <label class="" for="">ADD</label>
                            <button type="submit" class="btn btn-primary form-control form-control-sm"
                                    id="btnAdicionarProduto">
                                +
                            </button>
                        </div>
                    </div>
                </form>

                <div class="mb-3" >
                        <a class='btn btn-info' href='{{route('facturas.index')}}'><<
                            Voltar </a>

                    @if(session('carrinho_factura'))
                            <a class='btn btn-danger'
                               href='{{route('carrinho.compra.remover-todos')}}'> Remover Todos </a>

                            <a class='btn btn-success' href='{{route('facturas.finalizar')}}'>Próximo >> </a>
                    @endif



                </div>

                <div id="listar_carrinho" class="container-fluid" >
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
                        @if(session('carrinho_factura'))
                            @foreach(session('carrinho_factura') as $key => $cart)
                                @php
                                    $valor_desc = ($cart['valor'] - ($cart['valor']*($cart['desc']/100))) *$cart['qtd'];
                                        $total += $valor_desc;

                                @endphp
                                <tr>
                                    <td style="max-widtd: 600px;">{{$cart['product']}}</td>
                                    <td>{{$cart['qtd']}}</td>
                                    <td>{{$cart['desc']}}</td>
                                    <td class="text-right pr-5">{{number_format($cart['valor'], '2', ',', '.')}}</td>
                                    <td class="text-right pr-5 vlTotalProduto">{{number_format($valor_desc, '2', ',', '.')}}</td>
                                    <td class="text-center"><a class="btn btn-sm btn-danger"
                                                               href="{{route('carrinho.compra.remover', $key)}}"><i
                                                class="fa fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                        <tfoot class="">
                        @if(session('carrinho_factura'))
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th style="font-size: 18px" class="text-right mt-2 mb-2">SubTotal ❯</th>
                                <th style="font-size: 18px" class="text-right pr-5"
                                    id="vlTotalPedido">{{number_format($total, '2', ',', '.')}}</th>
                                <th></th>
                            </tr>


                        @endif

                        </tfoot>
                    </table>
                </div>

            </div>

            <div class="card-footer py-3">
                <span class="text-danger">(*) Campos Obrigatório</span>
            </div>

        </div>


    </div>
    <!-- /.container-fluid -->

@endsection

@section('js')


    <script>
        $(function () {
            $('.filtros_descricao').keyup(function (e) {
                e.preventDefault()
                var listar = $('.listar_inventories')

                $.ajax({
                    url: "{{route('inventories.by_name')}}",
                    type: 'get',
                    dataType: 'json',
                    data: {
                        product: $('.filtros_descricao').val(),
                        shops_id: $('.filtros_shops').val(),
                    },
                    success: function (data) {
                        var opcao = ''
                        if (data.length == 0) {
                            opcao = `<option value="">não encontrado</option>`
                            listar.css('color', 'red')
                        } else {
                            listar.css('color', 'black')
                            opcao = `<option value="">-- selecione o Produto --</option>`
                        }

                        Object.values(data).forEach(function (row) {
                            opcao += `<option value="${row.id}">${row.product}</option>`
                        })
                        listar.html(opcao)
                    },
                })
            })

            $('.filtros_shops').change(function (e) {
                e.preventDefault()
                $.ajax({
                    url: "{{route('inventories.filtro')}}",
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        shops_id: $('.filtros_shops').val(),
                        categorias_id: $('.filtros_categorias').val(),
                        unidades_id: $('.filtros_unidades').val(),
                    },
                    success: function (data) {
                        var opcao = ''
                        if (data.length == 0) {
                            opcao = `<option value="">não encontrado</option>`
                            $('.listar_inventories').css('color', 'red')
                        } else {
                            $('.listar_inventories').css('color', 'black')
                            opcao = `<option value="">-- selecione um serviço --</option>`
                        }

                        Object.values(data).forEach(function (row) {
                            opcao += `<option value="${row.id}">
                            ${row.products.product}



</option>`
                        })
                        $('.listar_inventories').html(opcao)
                    },
                })
            })

        })
    </script>

@endsection
