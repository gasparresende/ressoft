@extends('layouts.app')

@section('title', 'Users_shopp')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-primary">Lojas - Cadastro</h1>

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
                <form action="{{route('users_shops.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">

                            <label for="">Loja* </label>
                            <select class="form-control shops_id" name="shops_id">
                                <option value="">-- selecione uma loja --</option>
                                @foreach($shops as $shop)
                                    <option
                                        {{old('shops_id') == $shop->id? 'selected' : ''}} value="{{$shop->id}}">{{$shop->loja}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="">Users</label>
                            @foreach($users as $key=>$user)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{$user->id}}" name="users_id[]" id="check_user{{$key}}">
                                    <label class="form-check-label" for="check_user{{$key}}">
                                        {{$user->username}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-row">
                        <input class="btn btn-success mr-3" type="submit" value="Salvar">
                        <a class="btn btn-primary" href="{{route('users_shops.index')}}">Voltar</a>
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
            $('.shops_id__ll').change(function () {
                getReq('{{route('users.by.shop')}}', function () {
                    sucesso(function () {

                    })
                })
            })
        })
    </script>

@endsection
