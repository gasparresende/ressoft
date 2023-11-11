<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas_products', function (Blueprint $table) {
            $table->id();
            $table->decimal('desconto', 10,2);
            $table->foreignId('facturas_id')->constrained();
            $table->foreignId('inventories_id')->constrained();
            $table->integer('qtd');
            $table->decimal('preco', 10, 2);
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
        Schema::dropIfExists('facturas_products');
    }
}
