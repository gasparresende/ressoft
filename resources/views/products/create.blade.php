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

            </div>

            <div class="card-body">
                <form action="{{route('products.store')}}" method="post">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="">Código* </label>
                            <input type="text" class="form-control" name="codigo" id="codigo" value="{{old('codigo')? old('codigo') : $codigo}}" >
                            @if($errors->has('codigo'))
                                <div class="text-danger" style="font-size: 12px">
                                    {{ $errors->first('codigo') }}
                                </div>

                            @endif

                        </div>

                        <div class="form-group col-md-10">
                            <label for="">Produto* </label>
                            <input type="text" class="form-control" name="product" value="{{old('product')}}">
                            @if($errors->has('product'))
                                <div class="text-danger" style="font-size: 12px">
                                    {{ $errors->first('product') }}
                                </div>

                            @endif
                        </div>

                    </div>

                    <div class="form-row">


                        <div class="form-group col-md-6">
                            <label for="">Regime IVA</label>
                            <select class="form-control" name="regimes_id">
                                <option value="">-- selecione --</option>
                                @foreach($regimes as $regime)
                                    <option
                                        {{(old('regimes_id')==$regime->id)? 'selected' : ''}} value="{{$regime->id}}">{{$regime->motivo}}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Unidade </label>
                            <select class="form-control" name="unidades_id">
                                <option value="">-- selecione --</option>
                                @foreach($unidades as $unidade)
                                    <option
                                        {{(old('unidades_id')==$unidade->id)? 'selected' : ''}} value="{{$unidade->id}}">{{$unidade->unidade}}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Tipo</label>
                            <select class="form-control" name="tipo">
                                <option value="">-- selecione --</option>
                                <option {{(old('tipo') == 'P')? 'selected' : ''}}  value="P">Produto</option>
                                <option {{(old('tipo') == 'P')? 'selected' : ''}}  value="S">Serviço</option>

                            </select>

                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Localização  </label>
                            <input type="text" class="form-control" name="localizacao" value="{{ old('localizacao')}}">
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
