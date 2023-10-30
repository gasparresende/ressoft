@extends('layouts.app')

@section('title', 'Shop')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-primary">Gestão de Mesa</h1>

        <div class="card shadow text-dark font-weight-bold mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Abrir Mesa</h6>


            </div>

            <div class="card-body">
                <form action="{{route('mesas.abrir.store')}}" method="post">
                    @csrf

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="">Mesa* </label>
                            <select  type="text" class="form-control" name="mesas_id" id="">
                                <option value="">-- select --</option>
                                @foreach($mesas as $mesa)
                                    <option {{old('mesas_id')==$mesa->id? 'selected' : ''}} value="{{$mesa->id}}">{{$mesa->mesa}}</option>

                                @endforeach
                            </select>
                            @if($errors->has('mesas_id'))
                                <div class="text-danger" style="font-size: 12px">
                                    {{ $errors->first('mesas_id') }}
                                </div>

                            @endif
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">Users </label>
                            <select type="text" class="form-control" name="users_id" id="">
                                <option value="">-- select --</option>
                                @foreach($users as $user)
                                    <option {{old('users_id')==$user->id? 'selected' : ''}} value="{{$user->id}}">{{$user->username}}</option>

                                @endforeach
                            </select>
                            @if($errors->has('users_id'))
                                <div class="text-danger" style="font-size: 12px">
                                    {{ $errors->first('users_id') }}
                                </div>

                            @endif
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">Status* </label>
                            <select  type="text" class="form-control" name="status_id" id="">
                                <option value="">-- select --</option>
                                @foreach($status as $statu)
                                    <option {{old('status_id')==$statu->id? 'selected' : ''}} value="{{$statu->id}}">{{$statu->statu}}</option>

                                @endforeach
                            </select>
                            @if($errors->has('status_id'))
                                <div class="text-danger" style="font-size: 12px">
                                    {{ $errors->first('status_id') }}
                                </div>

                            @endif
                        </div>

                    </div>


                    <div class="form-row">
                        <a class="btn btn-primary mr-3" href="{{route('mesas.index')}}">Voltar</a>
                        <input class="btn btn-success" type="submit" value="Salvar">
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
