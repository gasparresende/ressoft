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
                <form action="{{route('products.update', $product->id)}}" method="post">
                    @csrf
                    @method('put')

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Produto* </label>
                            <input readonly type="text" class="form-control" name="produto" value="{{$product->produto}}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Preço Compra* </label>
                            <input readonly type="text" class="form-control dinheiro" name="preco_compra" value="{{$product->preco_compra}}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Preço Venda* </label>
                            <input readonly type="text" class="form-control dinheiro" name="preco_venda" value="{{$product->preco_venda}}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="">Código* </label>
                            <input readonly type="text" class="form-control" name="codigo" value="{{$product->codigo}}">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Unidade* </label>
                            <select disabled class="form-control" name="units_id">
                                <option value="">-- selecione --</option>
                                @foreach($units as $unity)
                                    <option {{($product->units_id == $unity->id)? 'selected' : ''}} value="{{$unity->id}}">{{$unity->unidade}}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group col-md-3">
                            <label for="">Categoria*</label>
                            <select disabled class="form-control" name="categories_id">
                                <option value="">-- selecione --</option>
                                @foreach($categories as $category)
                                    <option {{($product->categories_id == $category->id)? 'selected' : ''}} value="{{$category->id}}">{{$category->categoria}}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Tipo*</label>
                            <select disabled class="form-control" name="tipo">
                                <option value="">-- selecione --</option>
                                <option {{($product->tipo == 'P')? 'selected' : ''}} value="P">Produto</option>
                                <option {{($product->tipo == 'S')? 'selected' : ''}}  value="S">Serviço</option>

                            </select>

                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Validade </label>
                            <input readonly type="date" class="form-control" name="validade" value="{{$product->validade}}">
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
