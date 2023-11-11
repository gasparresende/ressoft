<!doctype html>
<html lang='pt-br'>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
    <meta name='viewport'
          content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css'>
    <title>Factura - Recibo</title>

    <style>
        hr {
            border: 1px black dotted;
        }

        #page {

            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
        }

        .folha {
            height: 300px;
            margin-bottom: 100px;
            text-align: center;
            /*margin: 0 auto;*/
            width: 222px;

        }

        table {
            margin: 0 auto;
        }

        table td {
            font-size: 9pt;
        }

        body {
            margin: 0px;
        }
        tbody tr td{
            font-size: 6pt;
        }

        h3 {
            border-radius: 10px;
            border: 1px solid black;
            font-size: 12pt;
        }

        .clientes {
            margin-top: 5px;
            margin-bottom: 20px;
            text-align: left;
        }

        .coluna1 {
            font-weight: bold;
            font-size: 8pt;
        }

        tr.primeira th {
            border: 1px solid black;
            font-size: 8pt;
            border-radius: 10px;
        }

        .produto {
            margin-bottom: 10px;
        }

        p {
            font-size: 6pt;
            margin-bottom: 0px;
        }

        .certificado {
            margin-bottom: 15px;
        }

        .total th {
            text-align: left;
            font-size: 7pt;
        }

        .total td {
            text-align: left;
            font-size: 6pt;
        }

        table tr th {
            font-size: 7pt;
        }

        .total table {
            width: 230px;
        }

        #operador {
            font-size: 8pt;
        }
    </style>
</head>
<body>

<div id='page'>

    <div class='folha'>
        <div class='log'>
            <h3>RESSOFT</h3>
        </div>
        <div class='cabecalho'>
            <hr>
            <p>Benfica - Patriota</p>
            <p>Telef. </p>
            <p>E-mail: </p>
            <p>NIF: </p>
            <hr>
        </div>

        <div class='cabecalho'>
            <h3>FACTURA - RECIBO</h3>
            <table border='1' cellspacing='0' cellpadding='2' width="100%">
                <tr>
                    <th>Nº</th>
                    <th>Data - Hora</th>
                </tr>
                <tr>
                    <td style='font-size: 7pt;'>{{$factura->numero}}</td>
                    <td style='font-size: 7pt;'>{{data_formatada($factura->data_emissao, 'd-m-Y H:i:s')}}</td>
                </tr>
            </table>

            <div class='clientes'>
                <span class='coluna1'>Nome: Consumidor final</span><br>
                <span class='coluna1'>NIF: Consumidor final</span>
            </div>
            <hr>
            <div class='produto'>
                <table cellspacing='0' cellpadding='2' width="100%">
                    <thead>
                    <tr>
                        <th colspan='3'>Produtos</th>
                    </tr>

                    <tr class='primeira'>
                        <th>QTD</th>
                        <th>P.Unit</th>
                        <th>P.Total</th>
                    </tr>
                    </thead>


                    <tbody>
                    @foreach($facturas as $produto)
                        <tr style="border: 1px solid black">
                            <td colspan='3' style="text-align: left; font-weight: bold">{{$produto->product}}</td>
                        </tr>
                        <tr style="border: 1px solid black">
                            <td>{{$produto->qtd}}</td>
                            <td>{{formatar_moeda($produto->preco)}}</td>
                            <td colspan='2'>{{formatar_moeda($produto->preco * $produto->qtd)}}</td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
            <hr>
            <div class='clientes' id='operador'>
                <span class='coluna1'>Operador: </span>
                <span>{{auth()->user()->username}}</span>
            </div>

            <hr>

            <div class='total'>
                <table>
                    <tr>
                        <th>TOTAL AKZ</th>
                        <td>{{0}}</td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <th>Entrega Cash</th>
                        <td>0</td>
                    </tr>

                    <tr>
                        <th>Entrega TPA</th>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <th>Troco</th>
                        <td>0</td>
                    </tr>

                    <tr>
                        <th>IVA (14%)</th>
                        <td>Isento</td>
                    </tr>


                </table>
            </div>
            <hr>
            <div class='certificado'>
                <p>Obrigado Volte Sempre!!</p>
                <p> Regime de Não Sujeição ao IVA</p>
                <p>Processado por programa Validado AG SOFT</p>
            </div>

        </div>


    </div>

</div>

</body>
</html>
