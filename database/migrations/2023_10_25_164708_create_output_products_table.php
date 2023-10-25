<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('output_products', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('products_id')->index('products_id');
            $table->integer('shops_id')->index('shops_id');
            $table->integer('qtd');
            $table->date('data');
            $table->string('tipo_saida', 30)->nullable()->default('Ajuste');
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
        Schema::dropIfExists('output_products');
    }
};
