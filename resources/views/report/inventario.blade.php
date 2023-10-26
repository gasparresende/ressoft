<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório de Inventário</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <style>
        * {
            font-family: sans-serif;
        }

        table {
            font-size: 10pt;
        }


        body {
            color: black;
        }

        p {
            font-size: 10pt;
        }
    </style>
</head>
<body>


<div class="container-fluid">

    <div class="mb-4">
        <h4 class="text-center text-info">Relatório de Inventário</h4>
        <p class="mt-2 mb-0">Data Atual: {{data_formatada(now())}}</p>
        {{--
        <p class="mt-2 mb-0">Data Inicial: {{data_formatada($request->data1)}}</p>
        <p class="">Data Final: {{data_formatada($request->data2)}}</p>
        --}}
    </div>

    <div id="principal" style="margin-top: 8px;">
        <table class="table table-sm table-striped">
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Modelo</th>
                <th>SN</th>
                <th>Classficação</th>
                <th>Departamento</th>
                <th>Valor Justo</th>
                <th>Valor Residual</th>
                <th>Taxa Depreciação</th>
                <th>Classe</th>
            </tr>
            @foreach($inventarios as $inventario)
                <tr>
                    <td>{{$inventario->id}}</td>
                    <td>{{$inventario->descricao}}</td>
                    <td>{{$inventario->modelo}} </td>
                    <td>{{$inventario->sn}} </td>
                    <td>{{$inventario->classificacao}} </td>
                    <td>{{$inventario->departamento}} </td>
                    <td>{{$inventario->valor_justo}} </td>
                    <td>{{$inventario->valor_residual}} </td>
                    <td>{{$inventario->taxa_depreciacao}} </td>
                    <td>{{$inventario->classe}} </td>
                </tr>
            @endforeach


        </table>
    </div>

    <div style="width: 30%; margin-top: 10px; float: left; margin-right: 30%">
        <p class="text-center">Elaborado Por</p>
        <hr style="border: 0.1px solid black">
        <p class="text-center mb-0">{{auth()->user()->username}}</p>
        <p class="text-center mb-0">{{data_formatada(now())}}</p>
    </div>

    <div style="width: 30%; margin-top: 10px; float: left">
        <p class="text-center">Aprovado Por</p>
        <hr style="border: 0.1px solid black">
    </div>

</div>

</body>
</html>
