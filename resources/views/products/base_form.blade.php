


<div class="form-row">
    <div class="form-group col-md-2">
        <label for="">Código* </label>
        <input type="text" class="form-control" name="codigo" id="codigo" value="{{isset($product)? $product->codigo: old('codigo')}}" >
        @if($errors->has('codigo'))
            <div class="text-danger" style="font-size: 12px">
                {{ $errors->first('codigo') }}
            </div>

        @endif

    </div>

    <div class="form-group col-md-10">
        <label for="">Produto* </label>
        <input type="text" class="form-control" name="product" value="{{isset($product)? $product->product: old('product')}}">
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
        <input type="text" class="form-control" name="localizacao" value="{{isset($product)? $product->localizacao: old('localizacao')}}">
    </div>

</div>







