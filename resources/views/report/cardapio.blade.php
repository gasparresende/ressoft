<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cardápio Restaurante</title>
</head>

<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        width: 100%;
        height: 100vh;
        color: white;
        background-image: url("img/menu-3168414_1280.jpg");
        background-repeat: no-repeat;
        background-size: cover;
    }

    * {
        padding: 0;
        margin: 0;
    }


    .card {
        width: 50%;
        height: 100vh;
        float: left;
        position: relative;
    }


    .header {
        height: 100vh;
        position: relative;
        padding-bottom: 250px;
    }

    h3 {
        font-size: 30px;
        margin-top: 15px;
        background-color: red;
        padding-left: 50px;
    }

    p {
        font-size: 16px;
        margin-top: 15px;
    }

    .row{
        width: 100%;
        padding-bottom: 500px;
    }
</style>
<body>

<div class="header">

</div>

<div class="row">
    <div class="card">
        <h3>Entradas</h3>

        <div style="padding: 20px 50px">
            @foreach($entradas as $entrada)
                <p>{{$entrada->products->product}} -------------- {{formatar_moeda($entrada->products->preco_venda)}} kz</p>
            @endforeach

        </div>
    </div>

    <div class="card">
        <h3>Sobremesa</h3>

        <div style="padding: 20px 50px">
            @foreach($sobremesas as $sobremesa)
                <p>{{$sobremesa->products->product}} -------------- {{formatar_moeda($sobremesa->products->preco_venda)}} kz</p>
            @endforeach

        </div>
    </div>


</div>

<div>
    <div class="card">
        <h3>Pratos</h3>

        <div style="padding: 20px 50px">
            @foreach($pratos as $prato)
                <p>{{$prato->products->product}} -------------- {{formatar_moeda($prato->products->preco_venda)}} kz</p>
            @endforeach

        </div>
    </div>

    <div class="card">
        <h3>Bebidas</h3>

        <div style="padding: 20px 50px">
            @foreach($bebidas as $bebida)
                <p>{{$bebida->products->product}} -------------- {{formatar_moeda($bebida->products->preco_venda)}} kz</p>
            @endforeach

        </div>
    </div>
</div>
</body>
</html>
