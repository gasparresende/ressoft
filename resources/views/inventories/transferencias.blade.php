@extends('layouts.app')

@section('title', 'Inventory')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-primary">Estoques - Cadastro</h1>

        <div class="card shadow text-dark font-weight-bold mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Transferência</h6>


            </div>

            <div class="card-body">
                <form action="{{route('inventories.store')}}" method="post">
                    @csrf
                    <input type="hidden" value="3" name="tipo">

                    <div class="row mb-2">
                        <div class="form-group col-md-3">
                            <label for="">Loja - Origem *</label>
                            <div class="input-group">
                                <select
                                    class="form-control form-control-sm shops_id @error('shops_id') is-invalid @enderror"
                                    name="shops_id"
                                    aria-describedby="shops_id_add"
                                    id="products_shops_id">
                                    <option value="">-- select an option --</option>
                                    @foreach($shops as $shop)
                                        @if(isset($stock))
                                            <option
                                                {{$stock->shops_id == $shop->id? 'selected' : ''}} value="{{$shop->id}}">{{$shop->loja}}</option>
                                        @else
                                            <option
                                                {{old('shops_id') == $shop->id? 'selected' : ''}} value="{{$shop->id}}">{{$shop->loja}}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#localizacao">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                                @error('shops_id')

                                <span class="invalid-feedback ml-2 mt-2" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">Loja - Destino *</label>
                            <div class="input-group">
                                <select
                                    class="form-control form-control-sm shops_id2 @error('shops_id2') is-invalid @enderror"
                                    name="shops_id2"
                                    aria-describedby="shops_id2_add"
                                    id="products_shops_id2">
                                    <option value="">-- select an option --</option>
                                    @foreach($shops as $shop)
                                        @if(isset($stock))
                                            <option
                                                {{$stock->shops_id2 == $shop->id? 'selected' : ''}} value="{{$shop->id}}">{{$shop->loja}}</option>
                                        @else
                                            <option
                                                {{old('shops_id2') == $shop->id? 'selected' : ''}} value="{{$shop->id}}">{{$shop->loja}}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#localizacao">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                                @error('shops_id2')

                                <span class="invalid-feedback ml-2 mt-2" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Produto *</label>
                            <div class="input-group">
                                <select
                                    class="form-control form-control-sm products_id @error('products_id') is-invalid @enderror"
                                    name="products_id"
                                    aria-describedby="products_id_add"
                                    id="products_products_id">
                                    <option value="">-- select an option --</option>
                                    @foreach($products as $product)
                                        @if(isset($stock))
                                            <option
                                                {{$stock->products_id == $product->id? 'selected' : ''}} value="{{$product->id}}">{{$product->product}}</option>
                                        @else
                                            <option
                                                {{old('products_id') == $product->id? 'selected' : ''}} value="{{$product->id}}">{{$product->product}}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#produto_modal">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                                @error('products_id')

                                <span class="invalid-feedback ml-2 mt-2" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                    </div>

                    <div class="row mb-3">

                        <div class="form-group col-md-2">
                            <label for="">Size</label>
                            <div class="input-group">
                                <select
                                        class="form-control form-control-sm sizes_id @error('sizes_id') is-invalid @enderror"
                                        name="sizes_id"
                                        aria-describedby="sizes_id_add"
                                        id="products_sizes_id">
                                    <option value="">-- select an option --</option>
                                    @foreach($sizes as $size)
                                        @if(isset($stock))
                                            <option
                                                {{$stock->sizes_id == $size->id? 'selected' : ''}} value="{{$size->id}}">{{$size->size}}</option>
                                        @else
                                            <option
                                                {{old('sizes_id') == $size->id? 'selected' : ''}} value="{{$size->id}}">{{$size->size}}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#size_modal">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                                @error('sizes_id')

                                <span class="invalid-feedback ml-2 mt-2" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Color</label>
                            <div class="input-group">
                                <select
                                        class="form-control form-control-sm colors_id @error('colors_id') is-invalid @enderror"
                                        name="colors_id"
                                        aria-describedby="colors_id_add"
                                        id="products_colors_id">
                                    <option value="">-- select an option --</option>
                                    @foreach($colors as $color)
                                        @if(isset($stock))
                                            <option
                                                {{$stock->colors_id == $color->id? 'selected' : ''}} value="{{$color->id}}">{{$color->color}}</option>
                                        @else
                                            <option
                                                {{old('colors_id') == $color->id? 'selected' : ''}} value="{{$color->id}}">{{$color->color}}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#color_modal">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                                @error('colors_id')

                                <span class="invalid-feedback ml-2 mt-2" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Marca</label>
                            <div class="input-group">
                                <select
                                        class="form-control form-control-sm marcas_id @error('marcas_id') is-invalid @enderror"
                                        name="marcas_id"
                                        aria-describedby="marcas_id_add"
                                        id="products_marcas_id">
                                    <option value="">-- select an option --</option>
                                    @foreach($marcas as $marca)
                                        @if(isset($stock))
                                            <option
                                                {{$stock->marcas_id == $marca->id? 'selected' : ''}} value="{{$marca->id}}">{{$marca->marca}}</option>
                                        @else
                                            <option
                                                {{old('marcas_id') == $marca->id? 'selected' : ''}} value="{{$marca->id}}">{{$marca->marca}}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#marca_modal">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                                @error('marcas_id')

                                <span class="invalid-feedback ml-2 mt-2" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Categoria</label>
                            <div class="input-group">
                                <select
                                        class="form-control form-control-sm categorias_id @error('categorias_id') is-invalid @enderror"
                                        name="categorias_id"
                                        aria-describedby="categorias_id_add"
                                        id="products_categorias_id">
                                    <option value="">-- select an option --</option>
                                    @foreach($categorias as $categoria)
                                        @if(isset($stock))
                                            <option
                                                {{$stock->categorias_id == $categoria->id? 'selected' : ''}} value="{{$categoria->id}}">{{$categoria->categoria}}</option>
                                        @else
                                            <option
                                                {{old('categorias_id') == $categoria->id? 'selected' : ''}} value="{{$categoria->id}}">{{$categoria->categoria}}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#categoria_modal">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                                @error('categorias_id')

                                <span class="invalid-feedback ml-2 mt-2" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Validity </label>
                            <input type="date" class="form-control form-control-sm @error('validade') is-invalid @enderror"
                                   name="validade" id="transferencias_validade"
                                   value="{{isset($stock)? $stock->validade : old('validade')}}">
                            @error('validade')
                            <span class="invalid-feedback ml-2 mt-2" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Current Stock </label>
                            <input readonly type="number" class="form-control form-control-sm @error('qtd_actual') is-invalid @enderror"
                                   name="qtd_actual" id="entradas_stocks_qtd_actual" value="{{old('qtd_actual')}}">
                            @error('qtd_actual')
                            <span class="invalid-feedback ml-2 mt-2" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="row mb-3">

                        <div class="form-group col-md-3">
                            <label for="">QTD * </label>
                            <input required type="number" class="form-control form-control-sm @error('qtd') is-invalid @enderror"
                                   name="qtd" id="entradas_stocks_qtd"
                                   value="{{isset($stock)? $stock->qtd : old('qtd')}}">
                            @error('qtd')
                            <span class="invalid-feedback ml-2 mt-2" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-9">
                            <label for="">Observation </label>
                            <input type="text" placeholder=""
                                   class="form-control form-control-sm @error('obs') is-invalid @enderror"
                                   name="obs"
                                   value="{{isset($stock)? $stock->obs : old('obs')}}">
                            @error('obs')
                            <span class="invalid-feedback ml-2 mt-2" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>


                    <div class="text-right">
                        <a class="btn btn-primary" href="{{route('inventories.index')}}"><i class="fa fa-backward"></i> Voltar</a>
                        <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Salvar</button>

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

    <script>
        $(function () {
            //Executar

            $('#products_shops_id, #products_products_id, #products_sizes_id, #products_colors_id, #transferencias_validade, #products_marcas_id, #products_categorias_id').change(function () {
                getStock_actual($('#products_shops_id'), $('#products_products_id'), $('#products_sizes_id'), $('#products_colors_id'), $('#products_marcas_id'), $('#products_categorias_id'), $('#transferencias_validade'), '#entradas_stocks_qtd_actual')
            })
        })
    </script>
@endsection
