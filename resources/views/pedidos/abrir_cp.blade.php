@extends('layouts.app')

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

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Mesa* </label>
                            <select class="form-control" name="mesas_id" id="">
                                <option value="">-- select --</option>
                                @foreach($mesas as $mesa)
                                    <option
                                        {{old('mesas_id')==$mesa->id? 'selected' : ''}} value="{{$mesa->id}}">{{$mesa->mesas->mesa}}</option>

                                @endforeach
                            </select>
                            @if($errors->has('mesas_id'))
                                <div class="text-danger" style="font-size: 12px">
                                    {{ $errors->first('mesas_id') }}
                                </div>

                            @endif
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
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

                        <div class="form-group col-md-9">
                            <label for="">Observção </label>
                            <input class="form-control" type="text" autofocus
                                   placeholder="Adicionar aqui mais detalhe do produto solicitado"
                                   name="obs" id="">
                        </div>


                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="">Search </label>
                            <input class="form-control" type="search" name="serach" id="">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Código </label>
                            <input class="form-control" type="text" autofocus placeholder="código de barra do produto"
                                   name="codigo" id="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Produto* </label>
                            <select class="form-control" name="produtos_id" id="">
                                <option value="">-- select --</option>
                                @foreach($produtos as $produto)
                                    <option
                                        {{old('produtos_id')==$produto->id? 'selected' : ''}} value="{{$produto->id}}">{{$produto->products->product}} {{$produto->color!= null ? ' - '.$produto->color: null}} {{$produto->size != null ? ' - '.$produto->size : null}} {{$produto->validade != null ? ' - '.data_formatada($produto->validade) : null}}</option>

                                @endforeach
                            </select>
                            @if($errors->has('produtos_id'))
                                <div class="text-danger" style="font-size: 12px">
                                    {{ $errors->first('produtos_id') }}
                                </div>

                            @endif
                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Quantidade * </label>
                            <input class="form-control" type="number" name="qtd" value="1">
                            @if($errors->has('qtd'))
                                <div class="text-danger" style="font-size: 12px">
                                    {{ $errors->first('qtd') }}
                                </div>

                            @endif
                        </div>

                    </div>

                    <div class="form-row mb-3">
                        <div class="card">
                            <div class="card-body">

                            </div>
                        </div>
                    </div>



                    <div class="text-right">
                        <button class="btn btn-success" type="submit">Adicionar <i class="fa fa-plus-circle"></i>
                        </button>

                    </div>

                    <div class="mt-3 mb-3">
                        <h4 class="text-center alert alert-info">Produto Adicionado - Mesa Nº x</h4>
                        <table class="tabela table-sm table table-striped">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Mesa</th>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Valor</th>
                                <th>Subtotal</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pedidos as $pedido)
                                <tr>
                                    <td>{{$pedido->id}}</td>
                                    <td>{{$pedido->status_mesas->mesas->mesa}}</td>
                                    <td>{{$pedido->inventories->products->product}}</td>
                                    <td>{{$pedido->qtd}}</td>
                                    <td>{{formatar_moeda($pedido->preco)}}</td>
                                    <td>{{formatar_moeda($pedido->preco* $pedido->qtd)}}</td>
                                    <td>
                                        <a class="btn btn-danger btn-sm" href="#"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>


                    <div class="text-right">
                        <a class="btn btn-primary mr-2" href="{{route('pedidos.index')}}"><i class="fa fa-backward"></i>
                            Voltar</a>
                        <a class="btn btn-success" href="{{route('pedidos.index')}}">Finalizar <i
                                class="fa fa-save"></i> </a>
                    </div>
                </form>
            </div>

            <div class="card-footer py-3">
                <span class="text-danger">(*) Campos Obrigatório</span>
            </div>

        </div>


    </div>
    <!-- /.container-fluid -->

@endsection

@section('js')

@endsection
