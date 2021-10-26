@extends('layouts.app')

@section('title', 'sele')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Vendas - Meios de Pagamentos</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Meios de Pagamentos</h6>
            </div>

            <div class="card-body">
                <form action="{{route('carrinho_meio_pagamentos.adicionar')}}" method="post">
                    @csrf

                    <div class="row mb-4">
                        <div class="form-group col-md-2">
                            <label for="">Total Venda</label>
                            <input type="text" class="form-control bg-success text-white" readonly value="{{total_carrinho()}}">

                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Meios de Pagamentos</label>
                            <select class="form-control" name="id">
                                @foreach($meio_pagamentos as $meio_pagamento)
                                    <option value="{{$meio_pagamento->id}}">{{$meio_pagamento->meio}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">Valor *</label>
                            <input autofocus required type="text" class="form-control dinheiro" name="valor">
                        </div>


                        <div class="form-group col-md-2">
                            <label for="">ADD</label>
                            <button type="submit" class="form-control btn btn-primary">+</button>
                        </div>

                    </div>


                </form>

                <!-- Resultdado do carrinho -->
                <table class="table table-sm table-striped mt-3">
                    <thead>
                    <tr>
                        <th style="max-width: 600px;">Meio de Pagamento</th>
                        <th class="text-right pr-5">Valor (kz)</th>
                        <th class="text-center">Ação</th>
                    </tr>
                    </thead>
                    <tbody>

                    @if(session('carrinho_meio_pagamento'))
                        @foreach(session('carrinho_meio_pagamento') as $key => $cart)

                            <tr>
                                <td style="max-width: 600px;">{{$cart['meio']}}</td>
                                <td class="text-right pr-5">{{formatar_moeda($cart['valor'])}}</td>
                                <td class="text-center"><a class="btn btn-danger" href="{{route('carrinho_meio_pagamentos.remover', $key)}}">remover</a></td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                    <tfoot class="">

                    @if(session('carrinho_meio_pagamento'))
                        <tr class="{{(troco() >=0 ? (troco()==0? 'text-white bg-success' : 'text-dark bg-warning') : 'text-white bg-danger' )}}"  style="font-weight: bold; font-size: 15pt">
                            <th class="text-left">Troco ❯</th>
                            <th class="text-right">{{troco()}}</th>
                            <th></th>
                        </tr>
                        <a class="btn btn-success" href="{{route('seles.next2')}}">Próximo >></a>

                        <a class="btn btn-danger" style="margin-left: 5px"
                           href="{{route('carrinho_meio_pagamentos.remover.todos')}}">Remover Todos</a>
                    @endif

                    <a class="btn btn-primary" style="margin-left: 5px"
                       href="{{route('seles.create')}}"><< Voltar</a>
                    </tfoot>
                </table>
            </div>

        </div>

    </div>
    <!-- /.container-fluid -->

@endsection

@section('js')

@endsection
