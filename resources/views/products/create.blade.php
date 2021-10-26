@extends('layouts.app')

@section('title', 'Product')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-primary">Produtos - Cadastro</h1>

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
                <form action="{{route('products.store')}}" method="post">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Produto* </label>
                            <input required type="text" class="form-control" name="produto" value="{{old('produto')}}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Preço Compra* </label>
                            <input required type="text" class="form-control dinheiro" name="preco_compra"
                                   value="{{old('preco_compra')}}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Preço Venda* </label>
                            <input required type="text" class="form-control dinheiro" name="preco_venda"
                                   value="{{old('preco_venda')}}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="">Código* </label>
                            <input required type="text" class="form-control" name="codigo" value="{{old('codigo')}}">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Unidade* </label>
                            <select required class="form-control" name="units_id">
                                <option value="">-- selecione --</option>
                                @foreach($units as $unity)
                                    <option
                                        {{(old('units_id')==$unity->id)? 'selected' : ''}} value="{{$unity->id}}">{{$unity->unidade}}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group col-md-3">
                            <label for="">Categoria*</label>
                            <select required class="form-control" name="categories_id">
                                <option value="">-- selecione --</option>
                                @foreach($categories as $category)
                                    <option
                                        {{(old('categories_id')==$category->id)? 'selected' : ''}} value="{{$category->id}}">{{$category->categoria}}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Tipo*</label>
                            <select required class="form-control" name="tipo">
                                <option value="">-- selecione --</option>
                                <option {{(old('tipo') == 'P')? 'selected' : ''}}  value="P">Produto</option>
                                <option {{(old('tipo') == 'P')? 'selected' : ''}}  value="S">Serviço</option>

                            </select>

                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Validade </label>
                            <input type="date" class="form-control" name="validade" value="{{old('validade')}}">
                        </div>
                    </div>

                    <div class="form-row">
                        <input class="btn btn-success mr-3" type="submit" value="Salvar">
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
