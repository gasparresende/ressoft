@extends('layouts.app')

@section('title', 'Product')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-dark">Produtos - Vizualizar</h1>

        <div class="card shadow text-dark font-weight-bold mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Vizualizar Registro</h6>

            </div>

            <div class="card-body">
                <form action="{{route('products.update', $product->id)}}" method="post">
                    @csrf
                    @method('put')

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="">Código* </label>
                            <input readonly type="text" class="form-control" name="codigo" id="codigo" value="{{$product->codigo}}" >
                            @if($errors->has('codigo'))
                                <div class="text-danger" style="font-size: 12px">
                                    {{ $errors->first('codigo') }}
                                </div>

                            @endif

                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Produto* </label>
                            <input readonly type="text" class="form-control" name="product" value="{{$product->product}}">
                            @if($errors->has('product'))
                                <div class="text-danger" style="font-size: 12px">
                                    {{ $errors->first('product') }}
                                </div>

                            @endif
                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Preço Venda </label>
                            <input readonly type="text" class="form-control dinheiro" name="preco_venda" id="preco_venda" value="{{$product->preco_venda}}" >
                            @if($errors->has('preco_venda'))
                                <div class="text-danger" style="font-size: 12px">
                                    {{ $errors->first('preco_venda') }}
                                </div>

                            @endif

                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Preço Compra </label>
                            <input readonly type="text" class="form-control dinheiro" name="preco_compra" id="preco_compra" value="{{$product->preco_compra}}" >
                            @if($errors->has('preco_compra'))
                                <div class="text-danger" style="font-size: 12px">
                                    {{ $errors->first('preco_compra') }}
                                </div>

                            @endif

                        </div>

                    </div>

                    <div class="form-row">


                        <div class="form-group col-md-6">
                            <label for="">Regime IVA</label>
                            <select disabled class="form-control" name="regimes_id">
                                <option value="">-- selecione --</option>
                                @foreach($regimes as $regime)
                                    <option
                                        {{($product->regimes_id==$regime->id)? 'selected' : ''}} value="{{$regime->id}}">{{$regime->motivo}}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Unidade </label>
                            <select disabled class="form-control" name="unidades_id">
                                <option value="">-- selecione --</option>
                                @foreach($unidades as $unidade)
                                    <option
                                        {{($product->unidades_id==$unidade->id)? 'selected' : ''}} value="{{$unidade->id}}">{{$unidade->unidade}}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Tipo</label>
                            <select disabled class="form-control" name="tipo">
                                <option value="">-- selecione --</option>
                                <option {{($product->tipo ==='P')? 'selected' : ''}}  value="P">Produto</option>
                                <option {{($product->tipo == 'S')? 'selected' : ''}}  value="S">Serviço</option>

                            </select>

                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Localização  </label>
                            <input readonly type="text" class="form-control" name="localizacao" value="{{isset($product)? $product->localizacao: old('localizacao')}}">
                        </div>

                    </div>


                    <div class="form-row">
                        <a class="btn btn-primary" href="{{route('products.index')}}">Voltar</a>
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
