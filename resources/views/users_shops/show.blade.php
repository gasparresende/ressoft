@extends('layouts.app')

@section('title', 'Users_shopp')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-dark">Lojas - Vizualizar</h1>

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
                <form action="{{route('users_shopps.update', $users_shopp->id)}}" method="post">
                    @csrf
                    @method('put')

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Loja* </label>
                            <input readonly type="text" class="form-control" name="loja" value="{{$users_shopp->loja}}">
                        </div>

                    </div>


                    <div class="form-row">
                        <a class="btn btn-primary" href="{{route('users_shopps.index')}}">Voltar</a>
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
