@extends('layouts.app')

@section('title', 'Product')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Balancete</h1>

        <div class="text-left" style="margin-bottom: 5px">
            @can('exportar_excel')
                <a href="#" class="btn btn-sm btn-outline-success" data-toggle="modal"
                   data-target="#balancete_exportar"
                   id="btn_novo_roles">Exportar Excel <i class="fa fa-file-excel-o"></i> </a>
            @endcan

            @can('dr')
                <a href="#" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#dr"
                   id="btn_novo_roles">Demonstração de Resultado <i class="fa fa-download"></i> </a>
            @endcan

        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Listar Todos</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="padding: 10px">
                    @php
                        $debito= 0;
                        $credito= 0;
                        $devedor= 0;
                        $credor= 0;
                    @endphp
                    @foreach($balancete as $row)
                        @php
                            $debito += $row->tot_deb;
                            $credito += $row->tot_cre;

                            $saldo_devedor = ($row->tot_deb > $row->tot_cre)? $row->tot_deb - $row->tot_cre : 0;
                            $saldo_credor = ($row->tot_deb > $row->tot_cre)? 0 : $row->tot_cre - $row->tot_deb;

                            $devedor += $saldo_devedor;
                            $credor += $saldo_credor;
                        @endphp
                    @endforeach

                    <form action="">
                        <div class="row mb-4">
                            <div class="form-group col-md-3">
                                <input class="form-control form-control-sm min" type="date" name="min">
                            </div>
                            <div class="form-group col-md-3">
                                <input class="form-control form-control-sm max" type="date" name="max">
                            </div>
                        </div>
                    </form>

                    <table class="table table-striped" id="balancete">
                        <thead>
                        <tr>
                            {{--<th>Data</th>--}}
                            <th>Descrição Conta</th>
                            <th>Débito</th>
                            <th>Crédito</th>
                            <th>Devedor</th>
                            <th>Credor</th>
                            {{-- <th>Ações</th>--}}
                        </tr>
                        <tr>
                            <th>TOTAL GERAL</th>
                            <th>{{number_format($debito, '2', ',', '.')}}</th>
                            <th>{{number_format($debito, '2', ',', '.')}}</th>
                            <th>{{number_format($devedor, '2', ',', '.')}}</th>
                            <th>{{number_format($credor, '2', ',', '.')}}</th>

                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $debito= 0;
                            $credito= 0;
                            $devedor= 0;
                            $credor= 0;
                        @endphp
                        @foreach($balancete as $row)
                            @php
                                $debito += $row->tot_deb;
                                $credito += $row->tot_cre;

                                $saldo_devedor = ($row->tot_deb > $row->tot_cre)? $row->tot_deb - $row->tot_cre : 0;
                                $saldo_credor = ($row->tot_deb > $row->tot_cre)? 0 : $row->tot_cre - $row->tot_deb;

                                $devedor += $saldo_devedor;
                                $credor += $saldo_credor;
                            @endphp
                            <tr>
                                {{--<td>{{date('Y-m-d', strtotime($row->data_movimento))}}</td>--}}
                                <td>{{$row->conta}} - {{$row->descricao}}</td>
                                <td>{{number_format($row->tot_deb, '2', ',', '.')}}</td>
                                <td>{{number_format($row->tot_cre, '2', ',', '.')}}</td>
                                <td>{{number_format($saldo_devedor, '2', ',', '.')}}</td>
                                <td>{{number_format($saldo_credor, '2', ',', '.')}}</td>

                            </tr>
                        @endforeach

                        </tbody>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>

                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="balancete_exportar">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h3 class="modal-title text-center text-white">Exportar Balancete</h3>
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>--}}
                </div>
                <form action="{{route('excel.exportar-balancete')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="">Contas</label>
                                <select class="form-control form-control-sm" name="contas_id">
                                    <option value="%">-- selecione uma conta --</option>
                                    @foreach($contas as $row)
                                        <option value="{{$row->id}}">{{$row->conta}}
                                            - {{$row->descricao}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="">Data Início</label>
                                <input class="form-control form-control-sm" type="date" name="data_inicio">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Data Final</label>
                                <input class="form-control form-control-sm" type="date" name="data_final">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Exportar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- FIM Modal -->

@endsection

@section('js')

@endsection
