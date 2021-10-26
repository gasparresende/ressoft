@extends('layouts.app')

@section('title', 'sele')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Vendas - Finalizar</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Finalizar Venda</h6>
            </div>
            <div class="card-body">

                <form action="{{route('seles.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="valor">Valor Total</label>
                            <input readonly class="form-control" type="text" value="{{total_carrinho()}}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Mês</label>
                            <select class="form-control" type="" name="mes">
                                <option {{(date('m')==1)? 'selected' : ''}} value="Janeiro">Janeiro</option>
                                <option {{(date('m')==2)? 'selected' : ''}} value="Fevereiro">Fevereiro</option>
                                <option {{(date('m')==3)? 'selected' : ''}} value="Março">Março</option>
                                <option {{(date('m')==4)? 'selected' : ''}} value="Abril">Abril</option>
                                <option {{(date('m')==5)? 'selected' : ''}} value="Maio">Maio</option>
                                <option {{(date('m')==6)? 'selected' : ''}} value="Junho">Junho</option>
                                <option {{(date('m')==7)? 'selected' : ''}} value="Julho">Julho</option>
                                <option {{(date('m')==8)? 'selected' : ''}} value="Agosto">Agosto</option>
                                <option {{(date('m')==9)? 'selected' : ''}} value="Setembro">Setembro</option>
                                <option {{(date('m')==10)? 'selected' : ''}} value="Outubro">Outubro</option>
                                <option {{(date('m')==12)? 'selected' : ''}} value="Novembro">Novembro</option>
                                <option {{(date('m')==12)? 'selected' : ''}} value="Dezembro">Dezembro</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Ano</label>
                            <select class="form-control" type="" name="ano">
                                @for($i = date('Y')-10; $i <= date('Y')+5; $i++)
                                    <option {{(date('Y')==$i)? 'selected' : ''}} value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="facturas_nome">Clientes *</label>
                            <select required class="form-control" type="text" name="customers_id">
                                @foreach($customers as $customer)
                                    <option value="{{$customer->id}}">{{$customer->customer}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <input class="form-control btn btn-success" type="submit" value="Finalizar">
                        </div>
                        <div class="form-group col-md-6">
                            <a class="form-control btn btn-primary" href="{{route('seles.create')}}">Voltar</a>
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
    <!-- /.container-fluid -->

@endsection

@section('js')

    <script>
        $(function () {


        })
    </script>
@endsection
