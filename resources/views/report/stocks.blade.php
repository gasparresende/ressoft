<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório de Stock</title>


    <style>
        *{
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse; /* CSS2 */
            background: #FFFFF0;
        }

        table td {
            border: 1px solid black;
        }

        table th {
            border: 1px solid black;
            background: #F0FFF0;
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


        <h4 class="text-center text-info">Relatório de Stock - {{$inventories->first()->loja}}</h4>
        <p class="mt-2 mb-0">Data Inicial: {{data_formatada($request->data1)}}</p>
        <p class="">Data Final: {{data_formatada($request->data2)}}</p>
    </div>

    <div id="principal" style="margin-top: 8px;">
        <table class="table table-sm table-striped">
            <tr>
                <th>ID</th>
                <th>Loja</th>
                <th>Product</th>
                <th>Stock Inicial</th>
                <th>Entradas</th>
                <th>Saídas</th>
                <th>Stock Final</th>
            </tr>
            @foreach($inventories as $stock)

                <tr>
                    <td>{{$stock->id}}</td>
                    <td>{{$stock->loja}}</td>
                    <td>{{$stock->product}} {{$stock->color!= null ? ' - '.$stock->color: null}} {{$stock->size != null ? ' - '.$stock->size : null}} {{$stock->validade != null ? ' - '.data_formatada($stock->validade) : null}}</td>
                    <td>{{$stock->qtd_final - getStock($stock->shops_id, $stock->products_id, $stock->sizes_id, $stock->colors_id, $stock->marcas_id, $stock->categorias_id, $stock->validade, $request->data1, $request->data2)['entradas'] - getStock($stock->shops_id, $stock->products_id, $stock->sizes_id, $stock->colors_id, $stock->marcas_id, $stock->categorias_id, $stock->validade, $request->data1, $request->data2)['saidas']}}</td>
                    <td>{{getStock($stock->shops_id, $stock->products_id, $stock->sizes_id, $stock->colors_id, $stock->marcas_id, $stock->categorias_id, $stock->validade, $request->data1, $request->data2)['entradas']}}</td>
                    <td>{{getStock($stock->shops_id, $stock->products_id, $stock->sizes_id, $stock->colors_id, $stock->marcas_id, $stock->categorias_id, $stock->validade,  $request->data1, $request->data2)['saidas']}}</td>
                    <td>{{$stock->qtd_final}}</td>

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
