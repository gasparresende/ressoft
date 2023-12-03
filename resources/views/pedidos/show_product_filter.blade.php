<div class="card-body">

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 show_products">

        <!-- Inicio Card -->
        @foreach($produtos as $produto)

            <form action="/pedidos/adicionar/{{$mesa->id}}/cart" method="post">
                @csrf
                <div class="col">
                    <div class="card shadow-sm">
                        <div style="font-size: 10pt"
                             class="card-header">
                            {{$produto->products->product}}
                            {{$produto->sizes ? ' - '.$produto->sizes->size : ''}}
                            {{$produto->colors ? ' - '.$produto->colors->color : ''}}
                            {{$produto->marcas ? ' - '.$produto->marcas->marca : ''}}
                            {{$produto->categorias ? ' - '.$produto->categorias->categoria : ''}}

                        </div>

                        <button type="submit">
                            <img src="/storage/{{$produto->products->imagem}}"
                                 class="bd-placeholder-img card-img-top" width="100%" height="150"/>

                        </button>
                        <div class="card-body">
                            <p style="font-size: 8pt" class="card-text text-danger">
                                Loja: {{$produto->shops->loja}}</p>

                            <p style="font-size: 8pt" class="card-text text-primary">
                                Stock: {{$produto->qtd}}</p>

                            <div class="d-flex justify-content-between align-items-center">


                                <input type="hidden" name="inventories_id" value="{{$produto->id}}">
                                <div class="input-group flex-wrap ">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">
                                        Detalhes
                                    </button>

                                    <input class="form-control form-control-sm" name="qtd"
                                           type="number" value="1">
                                    <button class="btn btn-sm btn-outline-success" type="submit">
                                        Adicionar
                                    </button>
                                    {{--
                                    <a href="{{route('pedidos.adicionar.cart', ['mesa'=>$mesa, 'inventory'=>$produto->id])}}" class="btn btn-sm btn-outline-success">
                                        Adicionar
                                    </a>
                                    --}}

                                </div>


                            </div>
                            <div class="form-row mt-2">
                                <div class="form-group col-md-12">
                                    <label for="">Para Cozinha </label>
                                    <div class="form-control">
                                        <div class="form-check form-check-inline">
                                            <input checked class="form-check-input" type="radio"
                                                   name="cozinha"
                                                   id="inlineRadio1" value="0">
                                            <label class="form-check-label"
                                                   for="inlineRadio1">Não</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="cozinha"
                                                   id="inlineRadio2"
                                                   value="1">
                                            <label class="form-check-label"
                                                   for="inlineRadio2">Sim</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <input placeholder="Observação" class="form-control form-control-sm"
                                           name="obs"
                                           type="text" value="">
                                </div>


                            </div>


                        </div>
                    </div>
                </div>

            </form>
        @endforeach


    </div>

</div>
