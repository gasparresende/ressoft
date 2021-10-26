@extends('layouts.app')

@section('title', 'Product')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-primary">Empresas - Cadastro</h1>

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
                <form action="{{route('companies.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Nome* </label>
                            <input required autofocus type="text" class="form-control" name="nome" value="{{old('nome')}}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">NIF* </label>
                            <input required type="text" class="form-control" name="nif"
                                   value="{{old('nif')}}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Regime* </label>
                            <select required class="form-control" name="regimes_id">
                                <option value="">-- selecione --</option>
                                @foreach($regimes as $regime)
                                    <option
                                        {{(old('regimes_id')==$regime->id)? 'selected' : ''}} value="{{$regime->id}}">{{$regime->regime}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">E-mail </label>
                            <input type="email" class="form-control" name="email" value="{{old('email')}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">Telemóvel </label>
                            <input type="text" class="form-control" name="telemovel" value="{{old('telemovel')}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">Logotipo </label>
                            <input type="file" class="form-control" name="logotipo" value="{{old('logotipo')}}">
                        </div>

                    </div>

                    <div class="form-row">
                        <input class="btn btn-success mr-3" type="submit" value="Salvar">
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
