<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos_products', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('pedidos_id')->constrained();
            $table->foreignId('status_mesas_id')->constrained();
            $table->foreignId('inventories_id')->constrained();
            $table->integer('qtd');
            $table->decimal('preco', 10, 2);
            $table->boolean('cozinha')->default(0);
            $table->text('obs')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos_products');
    }
}
