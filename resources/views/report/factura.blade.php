<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>{{$tipo}} {{$factura->ano}}/{{$factura->numero}}</title>
    <style>
        p {
            margin-bottom: 0px;
            font-size: 8pt;
        }


        #iva th {
            text-align: center;
        }

        #banco p {
            font-size: 8pt;
        }

        #final p {
            font-size: 8pt;
        }

        #final {
            clear: both;
        }

        .negrito {
            font-weight: bold;
        }

        hr {
            border: 1px solid rgba(0, 0, 0, 0.53);
        }

        th, td {
            padding-right: 5px;
            padding-left: 5px;
            font-size: 7pt;
        }


        footer {
            bottom: 0;
            left: 0;
            height: 140px;
            position: absolute;
            width: 100%;
        }

        .conteudo {
            /** Altura do rodapé tem que ser igual a isso aqui e vice-versa **/
            padding-bottom: {{$facturas->count() <=30? 360 : 0}}px;
            page-break-after: always;
        }

        #bancos td {
            font-size: 7px;
        }


        #total_venda th {
            font-size: 7px;
        }

        #total_venda td {
            text-align: right;
        }

        * {
            font-family: Calibri, sans-serif;
        }

        th, tr, td {
            border: 1px solid black;
        }

        .descricao tr, td {
            border: none;
        }

    </style>
</head>
<body>


<div class="container-fluid">
    <div>

        <div class="text-left">
            @if($img)
                <img src="/storage/'{{empresas()->logotipo_empresa}}" alt=""
                     style="display: inline; width: 12%; position: absolute">
            @endif

        </div>

        <div style="text-align: right">
            <p class="negrito">{{$tipo}} {{$factura->ano}}/{{$factura->numero}}</p>
            <p><span
                    style="font-weight: bold">Data Emissão:</span> {{date('d-m-Y H:i:s', strtotime($factura->data_emissao))}}
            </p>
            <p><span
                    style="font-weight: bold">Data Vencimento:</span> {{date('d-m-Y', strtotime($factura->data_vencimento))}}
            </p>
            <p>REF. {{$factura->mes}} de {{$factura->ano}}</p>
            <p class="negrito">ORIGINAL</p>
        </div>
    </div>

    <hr>
    <div style="width: 100%; height: 180px;">

        <div class="text-left" style="width: 55%;  float: left;">
            <p class="negrito">{{empresas()->nome_empresa}}</p>
            <p>Telf: {{empresas()->telemovel_empresa}}</p>
            <p>Email: {{empresas()->email_empresa}}</p>
            <p>WebSite: {{empresas()->website_empresa}}</p>
            <p>{{empresas()->endereco_empresa}}</p>
            <p class="negrito">Contribuinte: {{empresas()->nif_empresa}}</p>
            @if ($t=='NC')
                <p style="margin-top: 5px; font-size: 8pt">Referente a Retificação de <span class="negrito"> {{nota_credito($factura->num)['tipo']}}. </span>
                    {{$factura->motivo_nc}}</p>

            @endif

        </div>

        <div style=" text-align: right;">
            <p class="negrito">Exmo(s), Sr(s). Contribuinte: {{$factura->nif}}</p>
            <p class="negrito">{{$factura->nome}}</p>
            <p>{{$factura->endereco}}</p>
            <p>Telm. {{$factura->telemovel}}</p>

        </div>
    </div>

    <div style="clear: both; margin-bottom: 10px; margin-top: 15px; height: 370px" class="">
        <table style="width: 100%" class="descricao">
            <tr style="border-top: 1px solid black; border-bottom: 1px solid black;" id="titulo">
                <th style="width: 3%">ID</th>
                <th>DESCRIÇÃO</th>
                <th style="width: 3%" class="text-center">QTD</th>
                <th style="width: 2%" class="text-center">UN.</th>
                <th style="width: 12%; text-align: right">P. UNITÁRIO</th>
                <th style="width: 9%" class="text-center">DESC (%)</th>
                <th style="width: 9%" class="text-center">TAXA (%)</th>
                <th style="width: 10%; text-align: right">TOTAL</th>
            </tr>

            @php
                $total_geral = 0;
                $tot_desconto = 0;
                $retencao = 0;
                $total = 0;
                $desconto = 0;
            @endphp
            @foreach($facturas as $row)

                @php
                    $p_unit = $row->punitario/1;

                        $codigo_isencao = !is_null($row->codigo)? " [$row->codigo] " : "";
                @endphp

                @for($i=1; $i<= 1; $i++)
                    <tr style="padding: 5px; font-size: 13px">
                        <td>{{$row->id_servico}}</td>
                        <td>{{str_contains($row->product, 'Serviço')? $row->servicos.$codigo_isencao.' - Ref. '.$factura->mes : $row->product.$codigo_isencao}}</td>
                        <td class="text-center">{{$row->qtd}}</td>
                        <td class="text-center">{{$row->unidade}}</td>
                        <td style="text-align: right">{{formatar_moeda($p_unit)}}</td>
                        <td class="text-center">{{$row->desconto}}</td>
                        <td class="text-center">taxa</td>
                        <td style="text-align: right">{{formatar_moeda( $p_unit * $row->qtd)}}</td>
                    </tr>
                @endfor

            @endforeach

            @php
                $taxa = 0;
            @endphp

        </table>

    </div>

    <div style="padding-bottom: 10px;  margin-bottom: 10px">

        <div style="float: left; width: 53%; margin-right: 2%" id="iva">

            <table width="100%" class="text-center" style="margin-bottom: 10px">
                <tr>
                    <th>Descrição</th>
                    <th>Taxa</th>
                    <th>Incidência</th>
                    <th>Imposto</th>
                </tr>
                @if(empresas()->regimes_id == 3)
                    <tr>
                        <td>{{empresas()->motivo}}</td>
                        <td>{{empresas()->taxa}} %</td>
                        <td>{{formatar_moeda($total)}}</td>
                        <td>{{formatar_moeda($total*$taxa)}} {{$factura->sigla_moeda}}</td>
                    </tr>
                @else
                    <tr>
                        <td>N/A</td>
                        <td>{{0}} %</td>
                        <td>{{formatar_moeda($total)}}</td>
                        <td>{{formatar_moeda(0)}} {{$factura->sigla_moeda}}</td>
                    </tr>
                @endif
            </table>

            <table border="1" width="100%" class="text-center" style="margin-bottom: 10px" id="bancos">
                <tr>
                    <th>Banco</th>
                    <th>Nº Conta</th>
                    <th>IBAN</th>
                </tr>

                @foreach($bancos as $banco)
                    <tr>
                        <td>{{0}} (Akz)</td>
                        <td>{{0}}</td>
                        <td>{{0}}</td>
                    </tr>
                @endforeach
            </table>
            <p><span
                    style="font-weight: bold">Operador:</span> {{ /*usuario($factura->users_id) != null? usuario($factura->users_id)->username :*/ $factura->username}}
            </p>

            <p style="margin-top: 10px; position: absolute">
                <img src="data:image/png;base64, {!! $qrcode !!}">
            </p>

        </div>

        <div style="float: left; width: 45%">
            <table border="1" width="100%" id="total_venda">
                <tr>
                    <th>Total Ilíquido</th>
                    <td> {{formatar_moeda($total)}} {{$factura->sigla_moeda}}</td>
                </tr>
                <tr>
                    <th>Total Descontos</th>
                    <td>{{formatar_moeda($desconto)}} {{$factura->sigla_moeda}}</td>
                </tr>
                <tr>
                    <th>Imposto</th>
                    <td>{{formatar_moeda($total*$taxa)}} {{$factura->sigla_moeda}}</td>
                </tr>
                <tr>
                    <th>0 %</th>
                    <td>{{formatar_moeda($retencao)}} {{$factura->sigla_moeda}}</td>
                </tr>
                <tr>
                    <th>Total Documento</th>
                    <td>{{number_format(($total-$desconto-$retencao+($total*$taxa)), '2', ',', '.')}} {{$factura->sigla_moeda}} </td>
                </tr>
            </table>

            <div style="margin-top: 10px; margin-bottom: 20px" id="final">
                <p style="color: darkblue; font-size: 6pt ">Valor
                    Extenso: {{extenso(round($total-$desconto-$retencao+($total*$taxa), 2), $factura->moedas_id)}} </p>

                <p style="color: darkblue; font-size: 6pt; margin-top: 10px ">{{$t == 'PP'? 'Este Documento Não Serve de Factura' : "Bens ou Serviços colocados a disposição do cliente a ".data_formatada($factura->data_emissao)." em Luanda."}} </p>

                <p>{{empresa()->regimes->motivo}}</p>


            </div>
        </div>


        <p style="clear: both; font-size: 7pt; font-family: 'Calibri';"
           class="text-center">{{certificacaoAGT($factura->hash)}}</p>

    </div>
    <div>
        <p style="text-align: right">Pag 1 de 1</p>
    </div>

</div>

</body>
</html>
