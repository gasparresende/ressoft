<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório de Venda</title>

    {{--
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
--}}
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

        td{
            text-align: center;
        }


        body {
            color: black;
        }

        p {
            font-size: 10pt;
        }

        h4 {
            text-align: center;
        }

        .text-center{
            text-align: center;
        }
    </style>
</head>
<body>


<div class="container-fluid">

    <div class="mb-4">
        <h4 class="text-center text-info">Relatório de Venda</h4>
        <p class="mt-2 mb-0">Data Inicial: {{data_formatada($request->data1)}}</p>
        <p class="">Data Final: {{data_formatada($request->data2)}}</p>
    </div>

    <div id="principal" style="margin-top: 8px;">
        <table class="table table-sm table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>QTD</th>
                <th>Preço</th>
                <th>Valor </th>
            </tr>
            </thead>
            @foreach($facturas as $factura)
                <tbody>
                <tr>
                    <td>{{$factura->id}}</td>
                    <td>{{$factura->product}}
                        {{$factura->marca!= null ? ' - '.$factura->marca: null}}
                        {{$factura->categoria!= null ? ' - '.$factura->categoria: null}}
                        {{$factura->color!= null ? ' - '.$factura->color: null}}
                        {{$factura->size != null ? ' - '.$factura->size : null}}
                        {{$factura->validade != null ? ' - '.data_formatada($factura->validade) : null}}</td>
                    <td>{{$factura->qtd}}</td>
                    <td>{{formatar_moeda($factura->preco_venda)}}</td>
                    <td>{{formatar_moeda($factura->preco_venda * $factura->qtd)}}</td>
                </tr>
                </tbody>
            @endforeach
            <tfoot>
            <tr>
                <th colspan="4">Total</th>
                <th>{{formatar_moeda($total)}}</th>
            </tr>
            </tfoot>


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
