@extends('layouts.app')

@section('title', 'Users_shopp')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-warning">Usuário Loja - Alterar</h1>

        <div class="card shadow text-dark font-weight-bold mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Alterar Registro</h6>

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
                <form action="{{route('users_shops.update', $users_shop->id)}}" method="post">
                    @csrf
                    @method('put')

                    <div class="row">
                        <div class="form-group col-md-6">

                            <label for="">Loja* </label>
                            <select class="form-control shops_id" name="shops_id">
                                <option value="">-- selecione uma loja --</option>
                                @foreach($shops as $shop)
                                    <option
                                        {{$users_shop->shops_id == $shop->id? 'selected' : ''}} value="{{$shop->id}}">{{$shop->loja}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">

                            <label for="">Users* </label>
                            <select class="form-control shops_id" name="users_id">
                                <option value="">-- selecione um User --</option>
                                @foreach($users as $user)
                                    <option
                                        {{$users_shop->users_id == $user->id? 'selected' : ''}} value="{{$user->id}}">{{$user->username}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>


                    <div class="form-row">
                        <input class="btn btn-success mr-3" type="submit" value="Alterar">
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

@endsection
