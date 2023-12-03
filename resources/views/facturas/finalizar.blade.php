@extends('layouts.app')

@section('title', 'Product')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h3 class="mb-3">Finalizar Documento</h3>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Finalizar</h6>
            </div>
            <div class="card-body">

                <form action="{{route('facturas.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="">Mês</label>
                            <select required class="form-control form-control-sm" type="" name="mes">
                                <option value=""> -- selecione --</option>
                                <option value="Janeiro">Janeiro</option>
                                <option value="Fevereiro">Fevereiro</option>
                                <option value="Março">Março</option>
                                <option value="Abril">Abril</option>
                                <option value="Maio">Maio</option>
                                <option value="Junho">Junho</option>
                                <option value="Julho">Julho</option>
                                <option value="Agosto">Agosto</option>
                                <option value="Setembro">Setembro</option>
                                <option value="Outubro">Outubro</option>
                                <option value="Novembro">Novembro</option>
                                <option value="Dezembro">Dezembro</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Ano</label>
                            <select class="form-control form-control-sm" type="" name="ano">
                                @for($i = date('Y')-10; $i <= date('Y')+5; $i++)
                                    <option {{(date('Y')==$i)? 'selected' : ''}} value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="valor">Data de Vencimento *</label>
                            <input required class="form-control form-control-sm" type="date" name="data_vencimento"
                                   value="{{date('Y-m-d')}}">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Tipo de Documento *</label>
                            <select required class="form-control form-control-sm" type="" name="tipos_id">
                                <option value="">-- selecione --</option>
                                @foreach($tipos as $tipo)
                                    <option value="{{$tipo->id}}">{{$tipo->tipo}}</option>                                        @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">Imposto *</label>
                            <select required class="form-control form-control-sm" type="" name="impostos_id">
                                <option value="">-- selecione --</option>
                                @foreach($impostos as $imposto)
                                    <option value="{{$imposto->id}}">{{$imposto->imposto}}</option>                                        @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="facturas_nome">Cliente *</label>
                            <select required class="form-control form-control-sm" type="text" name="clientes_id"
                                    id="facturas_servicos_nome">
                                <option value="">-- selecione um Cliente --</option>
                                @foreach($clientes as $row)
                                    <option value="{{$row->id}}">{{$row->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="valor">Valor Total</label>
                            <input readonly class="form-control form-control-sm" type="text" name="valor" id="valor"
                                   value="{{number_format($total, '2', ',', '.')}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="valor">Moeda</label>
                            <select class="form-control form-control-sm" name="moedas_id" id="moedas_id">
                                @foreach($moeda as $row)
                                    <option value="{{$row->id}}">{{$row->moeda}}</option>
                                @endforeach
                            </select>
                        </div>


                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <input class="form-control form-control-sm btn btn-success" type="submit" value="Finalizar">
                        </div>
                        <div class="form-group col-md-6">
                            <a class="form-control form-control-sm btn btn-primary" href="{{route('facturas.create')}}">Voltar</a>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="form-group col-md-6">
                            (*) Campos Obrigatório
                        </div>

                    </div>
                </form>

            </div>
        </div>

    </div>


@endsection

@section('js')


@endsection
