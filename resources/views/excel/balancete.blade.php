<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Balancete</title>

    <style>
        .sublinhado {
            text-decoration: underline;
            font-weight: bold;
        }
    </style>
</head>
<body>


<table>
    <thead>
    <tr>
        <th colspan="4" style="text-align: center"><h2>{{empresas()->nome_empresa}}</h2></th>
    </tr>
    <tr>
        <th colspan="4" style="text-align: center"><h3>Periódo: {{data_formatada($data_inicio)}}
                | {{data_formatada($data_final)}}</h3></th>
    </tr>
    <tr>
        <th colspan="4" style="text-align: center"><h3>Balancete</h3></th>
    </tr>
    <tr>
        <th colspan="4"></th>
    </tr>

    <tr>
        <th class="sublinhado">Conta</th>
        <th class="sublinhado">Tipo da Conta</th>
        {{--<th class="sublinhado">Saldo Anterior</th>--}}{{--Saldo anterior--}}
        <th class="sublinhado">Débito</th>
        <th class="sublinhado">Crédito</th>
    </tr>

    <tr>
        <th class="bg-primary">Net Profit</th>
        <th></th>
        {{--<th></th>--}}{{--Saldo anterior--}}
        <th>{{0}}</th>
        <th>{{netProfit($data_inicio,$data_final)}}</th>
    </tr>

    </thead>
    <tbody>
    @php
        $total_dev =0;
        $total_cre =0;
    @endphp

    @foreach($contas as $conta)
        @php
            $total_dev +=saldo_contas_devedor($conta->id, $data_inicio, $data_final);
            $total_cre +=saldo_contas_credor($conta->id, $data_inicio, $data_final);
        @endphp

        <tr>
            <td>{{ $conta->conta }} {{ $conta->descricao }}</td>
            <td>{{ $conta->tipo }}</td>
            {{--<td>{{ $saldo_devedor}}</td>--}}{{--Saldo anterior--}}
            <td>{{ saldo_contas_devedor($conta->id, $data_inicio, $data_final)}}</td>
            <td>{{ saldo_contas_credor($conta->id, $data_inicio, $data_final)}}</td>
        </tr>
    @endforeach

    </tbody>
    <tfoot>

    <tr>
        <th class="">TOTAL</th>
        <th class=""></th>
        {{--<th class=""></th>--}}{{--Saldo anterior--}}
        <th>{{$total_dev == '0'? '' : $total_dev}}</th>
        <th>{{$total_cre == '0'? '' : $total_cre+netProfit($data_inicio,$data_final)}}</th>
    </tr>

    <tr>
        <th colspan="4" style="text-align: center"></th>
    </tr>
    <tr>
        <th colspan="4" style="text-align: center"></th>
    </tr>

    </tfoot>
    <tr>
        <td></td>
        <td></td>
        {{--<td></td>--}}{{--Saldo anterior--}}
        <td></td>
        <td></td>
    </tr>
    <tr>
        <th class="bg-primary">Net Profit</th>
        <th></th>
        {{--<th></th>--}}{{--Saldo anterior--}}
        <th>{{netProfit($data_inicio,$data_final)}}</th>
        <th>{{0}}</th>
    </tr>
    <tbody>

    @php
        $total_dev =0;
        $total_cre =0;
    @endphp
    @foreach($contas2 as $conta)
        @php
            $total_dev +=saldo_contas_devedor2($conta->id, $data_inicio, $data_final);
            $total_cre +=saldo_contas_credor2($conta->id, $data_inicio, $data_final);
        @endphp

        <tr>
            <td>{{ $conta->conta }} {{ $conta->descricao }}</td>
            <td>{{ $conta->tipo }}</td>
            {{--<td>{{ $saldo_devedor}}</td>--}}{{--Saldo anterior--}}
            {{--<td>{{ saldo_anterior($conta->id, $data_inicio, $data_final)}}</td>--}}
            <td>{{ saldo_contas_devedor2($conta->id, $data_inicio, $data_final)}}</td>
            <td>{{ saldo_contas_credor2($conta->id, $data_inicio, $data_final)}}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>

    <tr>
        <th class="">TOTAL</th>
        <th class=""></th>
        {{--<th class=""></th>--}}{{--Saldo anterior--}}
        <th class="">{{$total_dev == '0'? '' : $total_dev+netProfit($data_inicio,$data_final)}}</th>
        <th class="">{{$total_cre == '0'? '' : $total_cre}}</th>
    </tr>

    <tr>
        <th colspan="4" style="text-align: center"></th>
    </tr>
    <tr>
        <th colspan="4" style="text-align: center"></th>
    </tr>
    <tr>
        <th colspan="4" style="text-align: center">AG-Count v1.0.0</th>
    </tr>
    <tr>
        <th colspan="4" style="text-align: center"><p>Processado por programa validado nº 282/AGT/2020 ZETASOFT</p></th>
    </tr>

    </tfoot>
</table>


</body>
</html>
