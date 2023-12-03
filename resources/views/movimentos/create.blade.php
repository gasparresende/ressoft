@extends('layouts.app')

@section('title', 'Shop')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h3 class="mb-3">Extracto de Movimento</h3>

        <div class="card shadow text-dark font-weight-bold mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Novo Registro</h6>

            </div>

            <div class="card-body">

                <form action="{{route('movimentos.store')}}" method="post">
                    @csrf

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">Contas (Débito) *</label>
                            <div id="movimentos_debito">

                                <select style="width: 51%; float: left; margin-right: 5px; margin-bottom: 5px"
                                        required class="form-control form-control-sm"
                                        name="debito[]">
                                    <option value="">-- selecione uma conta --</option>
                                    @foreach($contas as $row)
                                        <option value="{{$row->id}}">{{$row->conta}}
                                            - {{$row->descricao}}</option>
                                    @endforeach
                                </select>

                                <input name="valor[]" placeholder="Valor Débito"
                                       style="width: 40%; float: left; margin-bottom: 5px"
                                       class="form-control form-control-sm dinheiro v_deb" type="text">

                            </div>

                            <div id="novo_debito">

                            </div>
                            <button id="adicionar_debito" style="margin-top: 4px" type="button"
                                    class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> Débito
                            </button>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Contas (Crédito) *</label>
                            <div id="movimentos_credito">

                                <select style="width: 51%; float: left; margin-right: 5px; margin-bottom: 5px"
                                        required class="form-control form-control-sm"
                                        name="credito[]">
                                    <option value="">-- selecione uma conta --</option>
                                    @foreach($contas as $row)
                                        <option value="{{$row->id}}">{{$row->conta}}
                                            - {{$row->descricao}}</option>
                                    @endforeach
                                </select>

                                <input name="valor2[]" placeholder="Valor Crédito"
                                       style="width: 40%; float: left; margin-bottom: 5px"
                                       class="form-control form-control-sm dinheiro v_cre" type="text">

                            </div>

                            <div id="novo_credito">

                            </div>
                            <button id="adicionar_credito" style="margin-top: 4px" type="button"
                                    class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> Crédito
                            </button>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-md-9">
                            <label for="">Descrição *</label>
                            <input required class="form-control form-control-sm" type="text" name="razao">
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
                            <p>(*) Campos Obrigatório</p>
                            @can('acessos')
                                <button class="btn-sm btn-warning desbloquear_datas">Debloquear Datas</button>
                            @endcan
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

    <script>
        $(function () {
            $('#adicionar_debito').click(function () {
                $("#movimentos_debito").clone().appendTo("#novo_debito");
            })

            $('#adicionar_credito').click(function () {
                $("#movimentos_credito").clone().appendTo("#novo_credito");
            })

            $('.v_deb').keyup(function () {
                $('.v_cre').val($('.v_deb').val())
            })
        })
    </script>

@endsection
