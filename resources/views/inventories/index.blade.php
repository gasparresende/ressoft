@extends('layouts.app')

@section('title', 'Inventory')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Estoques - Cadastros</h1>

        <div class="text-left">
            <a class="btn btn-success mb-2" href=".entrada" data-toggle="modal">Entrada</a>
            <a class="btn btn-danger mb-2" href="{{route('inventories.create')}}">Saída</a>
            <a class="btn btn-warning mb-2" href="{{route('inventories.create')}}">Transferência</a>
            <a class="btn btn-dark mb-2" href="{{route('inventories.create')}}"><i class="fa fa-file-pdf"></i>
                Inventário</a>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listar Todos</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-striped tabela">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Produto</th>
                            <th>Loja</th>
                            <th>QTD</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($inventories as $inventory)

                            <tr>
                                <td>{{$inventory->id}}</td>
                                <td>{{$inventory->products->produto}}</td>
                                <td>{{$inventory->shops->loja}}</td>
                                <td>{{qtd_stock($inventory->products_id, $inventory->shops_id, $inventory->qtd)}}</td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <style>
                        .w-5 {
                            display: none;
                        }

                        .hidden {
                            display: none;
                        }
                    </style>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    <!-- Modal -->
    <div class="modal fade entrada" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Entrada de Produtos</h5>

                </div>
                <form action="#" method="post" id="entrada_produtos">
                    @csrf
                    <div class="modal-body">

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
                                        <input required type="number" class="form-control" name="qtd"
                                               value="{{old('qtd')}}">
                                    </div>
                                </div>


                            </div>

                            <div class="card-footer py-3">
                                <span class="text-danger">(*) Campos Obrigatório</span>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

@section('js')

    <script>
        $('#entrada_produtos').submit(function (e) {
            e.preventDefault()

            var data = $("#entrada_produtos").serialize()
            postReq('{{route('input_products.store')}}', function () {
                sucesso(function () {
                    var res = xhttp.responseText
                    alert(res)
                })
            }, data)
        })
    </script>
@endsection
