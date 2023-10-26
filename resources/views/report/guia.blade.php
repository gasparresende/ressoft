<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório de Stock</title>

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
            margin-bottom: 10px;
        }

        h3 {
            text-decoration: underline;
            text-align: center;
        }

        span {
            font-weight: bold;
        }

        h1 {
            text-align: center;
        }

        table, th, td {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            margin: auto;
        }

        th, td {
            padding: 10px;
            text-align: center;
            width: 120px;
        }

        th {
            font-weight: bold;
        }


        tr:nth-child(even) {
            background-color: #DCEBE6;
        }

        tr:hover:nth-child(1n + 2) {
            background-color: #085F63;
            color: #fff;
        }
    </style>
</head>
<body>


<div class="container-fluid">

    <div style="margin-bottom: 50px">
        <h3>NOTA DE ENTREGA</h3>
    </div>

    <div style="margin-bottom: 50px">
        <p>
            Confirmamos a entrega dos produtos abaixo:
        </p>
        <p><span>Nº Pedido: </span>{{$order->id}}</p>
        <p><span>Solicitado por: </span>{{$order->solicitado_por}}</p>

        <table>
            <tr>
                <th>Nº Ordem</th>
                <th>Produto</th>
                <th>Tamanho</th>
                <th>Cor</th>
                <th>Validade</th>
                <th>QTD Solicitada</th>
                <th>QTD Aprovada</th>
            </tr>

            @foreach($orders as $key=>$order)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$order->product}}</td>
                    <td>{{$order->size}}</td>
                    <td>{{$order->color}}</td>
                    <td>{{data_formatada($order->validade)}}</td>
                    <td>{{$order->qtd_solicitada}}</td>
                    <td>{{$order->qtd_aprovada}}</td>
                </tr>
            @endforeach
        </table>

    </div>


    <div style="margin-top: 50px">
        <div style="width: 30%; margin-top: 10px; float: left; margin-right: 30%">
            <p class="text-center">Solicitado Por</p>
            <hr style="border: 0.1px solid black">
        </div>

        <div style="width: 30%; margin-top: 10px; float: left">
            <p class="text-center">Aprovado Por</p>
            <hr style="border: 0.1px solid black">
            <p class="text-center">{{$order->aprovado_por}}</p>

        </div>
    </div>

</div>

</body>
</html>
