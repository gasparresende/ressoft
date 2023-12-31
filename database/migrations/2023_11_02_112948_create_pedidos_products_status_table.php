<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosProductsStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos_products_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedidos_products_id')->constrained();
            $table->foreignId('status_id')->constrained('status');
            $table->date('data')->default(now());

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
        Schema::dropIfExists('pedidos_products_status');
    }
}
