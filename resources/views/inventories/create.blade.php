@extends('layouts.app')

@section('title', 'Inventory')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-primary">Estoques - Cadastro</h1>

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
                <form action="{{route('inventories.store')}}" method="post">
                    @csrf

                    <div class="form-row">

                        <div class="form-group col-md-5">
                            <label for="">Produto*</label>
                            <select required class="form-control" name="products_id">
                                <option value="">-- selecione o produto --</option>
                                @foreach($products as $product)
                                    <option
                                        {{(old('products_id')==$product->id)? 'selected' : ''}} value="{{$product->id}}">{{$product->produto}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group col-md-5">
                            <label for="">Loja* </label>
                            <select required class="form-control" name="shops_id">
                                <option value="">-- selecione a loja --</option>
                                @foreach($shops as $shop)
                                    <option
                                        {{(old('shops_id')==$shop->id)? 'selected' : ''}} value="{{$shop->id}}">{{$shop->loja}}</option>
                                @endforeach
                            </select>

                        </div>


                        <div class="form-group col-md-2">
                            <label for="">Quantidade* </label>
                            <input required type="number" class="form-control" name="qtd" value="{{old('qtd')}}">
                        </div>
                    </div>

                    <div class="form-row">
                        <input class="btn btn-success mr-3" type="submit" value="Salvar">
                        <a class="btn btn-primary" href="{{route('inventories.index')}}">Voltar</a>
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
