@extends('layouts.app')

@section('title', 'Inventory')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-primary">Estoques - Cadastro</h1>

        <div class="card shadow text-dark font-weight-bold mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Saídas</h6>


            </div>

            <div class="card-body">
                <form action="{{route('inventories.store')}}" method="post">
                    @csrf
                    <input type="hidden" value="2" name="tipo">
                    <div class="row mb-3">

                        <div class="form-group col-md-4">
                            <label for="">Loja *</label>
                            <div class="input-group">
                                <select required
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

                        <div class="form-group col-md-4">
                            <label for="">Autorizado Por</label>
                            <div class="input-group">
                                <select
                                    class="form-control form-control-sm users_id @error('users_id') is-invalid @enderror"
                                    name="users_id2"
                                    aria-describedby="users_id_add"
                                    id="products_users_id">
                                    <option value="">-- select an option --</option>
                                    @foreach([] as $user)
                                        @if(isset($stock))
                                            <option
                                                {{$stock->users_id == $user->id? 'selected' : ''}} value="{{$user->id}}">{{$user->user}}</option>
                                        @else
                                            <option
                                                {{old('users_id') == $user->id? 'selected' : ''}} value="{{$user->id}}">{{$user->user}}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#user_modal">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                                @error('users_id')

                                <span class="invalid-feedback ml-2 mt-2" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">Motivo *</label>
                            <input required type="text" class="form-control form-control-sm" name="motivo">
                        </div>

                    </div>

                    <div class="row lista-produtos" id="lista-produtos">
                        <div class="form-group col-md-4">
                            <label for="">Product *</label>
                            <select required name="products_id[]" class="form-control form-control-sm mb-2">
                                <option value="">-- select --</option>
                                @foreach($products as $product)
                                    <option {{$product->id == 1000? 'selected' : ''}}  value="{{$product->id}}">{{$product->product}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="">Size </label>
                            <select name="sizes_id[]" class="form-control form-control-sm mb-2">
                                <option value="">-- select --</option>

                                @foreach($sizes as $size)
                                    <option {{$size->id == 1000? 'selected' : ''}}  value="{{$size->id}}">{{$size->size}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="">Color</label>
                            <select name="colors_id[]" class="form-control form-control-sm mb-2">
                                <option value="">-- select --</option>

                                @foreach($colors as $color)
                                    <option {{$color->id == 1000? 'selected' : ''}}  value="{{$color->id}}">{{$color->color}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Marca </label>
                            <select name="marcas_id[]" class="form-control form-control-sm mb-2">
                                <option value="">-- select --</option>

                                @foreach($marcas as $marca)
                                    <option {{$marca->id == 1000? 'selected' : ''}}  value="{{$marca->id}}">{{$marca->marca}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Categories </label>
                            <select name="categorias_id[]" class="form-control form-control-sm mb-2">
                                <option value="">-- select --</option>

                                @foreach($categorias as $categoria)
                                    <option {{$categoria->id == 1000? 'selected' : ''}}  value="{{$categoria->id}}">{{$categoria->categoria}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-1">
                            <label for="">Validade</label>
                            <input  name="validade[]" class="form-control form-control-sm mb-2"
                                    type="date" >
                        </div>

                        <div class="form-group col-md-1">
                            <label for="">QTD *</label>
                            <input required name="qtd[]" class="form-control form-control-sm mb-2"
                                   type="number" value="" min="1">
                        </div>

                    </div>
                    <div id="novo_pedido">

                    </div>
                    <div class="mb-3">

                        <button id="adicionar_pedido" style="margin-top: 4px" type="button"
                                class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> Add
                        </button>
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
            $('#adicionar_pedido').click(function () {
                $("#lista-produtos").clone().appendTo("#novo_pedido");
            })
        })
    </script>
@endsection
