@extends('layouts.app')

@section('title', 'Shop')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h3 class="mb-3">Movimento | Débito & Crédito</h3>

        <div class="card shadow text-dark font-weight-bold mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Novo Registro</h6>

            </div>

            <div class="card-body">

                <form action="{{route('movimentos.store2')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">Contas  *</label>
                            <select required class="form-control form-control-sm" name="contas">
                                <option value="">-- selecione uma conta --</option>
                                @foreach($contas as $row)
                                    <option value="{{$row->id}}">{{$row->conta}} - {{$row->descricao}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Tipo Movimento *</label>
                            <select required class="form-control form-control-sm" name="tipo">
                                <option value="">-- selecione uma opção --</option>
                                <option value="1">Débito</option>
                                <option value="2">Crédito</option>

                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">Descrição *</label>
                            <input required class="form-control form-control-sm" type="text" name="razao" >
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Valor *</label>
                            <input required class="form-control form-control-sm dinheiro" type="text" name="valor" >
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Data Movimento *</label>
                            <input required class="form-control form-control-sm desbloquear_movimentos" type="date"
                                   min="{{data_formatada(now(), 'Y-01')}}-01"
                                   max="{{data_formatada(now(), 'Y-m-d')}}" name="data_movimento">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <input class="form-control form-control-sm btn btn-success" type="submit" value="Salvar">
                        </div>
                        <div class="form-group col-md-6">
                            <a class="form-control form-control-sm btn btn-primary" href="{{route('movimentos.index')}}">Voltar</a>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="form-group col-md-6">
                            (*) Campos Obrigatório
                        </div>

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
