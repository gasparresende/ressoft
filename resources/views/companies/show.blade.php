@extends('layouts.app')

@section('title', 'Product')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-primary">Empresas - Vizualizar</h1>

        <div class="card shadow text-dark font-weight-bold mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Vizualizar Registro</h6>

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
                <form action="#" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Nome* </label>
                            <input readonly autofocus type="text" class="form-control" name="nome"
                                   value="{{$company->nome}}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">NIF* </label>
                            <input readonly type="text" class="form-control" name="nif"
                                   value="{{$company->nif}}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Regime* </label>
                            <select disabled class="form-control" name="regimes_id">
                                <option value="">-- selecione --</option>
                                @foreach($regimes as $regime)
                                    <option
                                        {{($company->regimes_id==$regime->id)? 'selected' : ''}} value="{{$regime->id}}">{{$regime->regime}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">E-mail </label>
                            <input readonly type="email" class="form-control" name="email" value="{{$company->email}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">Telemóvel </label>
                            <input readonly type="text" class="form-control" name="telemovel" value="{{$company->telemovel}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">Logotipo </label>
                            <input disabled type="file" class="form-control" name="logotipo" value="{{$company->logotipo}}">
                        </div>

                    </div>

                    <div class="form-row">
                        <a class="btn btn-primary" href="{{route('companies.index')}}">Voltar</a>
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
