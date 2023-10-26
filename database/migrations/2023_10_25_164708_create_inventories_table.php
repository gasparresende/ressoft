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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('products_id')->constrained();
            $table->foreignId('shops_id')->constrained();
            $table->foreignId('sizes_id')->nullable()->constrained();
            $table->foreignId('colors_id')->nullable()->constrained();
            $table->foreignId('marcas_id')->nullable()->constrained();
            $table->foreignId('categorias_id')->nullable()->constrained();
            $table->date('validade')->nullable();
            $table->integer('qtd');
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
        Schema::dropIfExists('inventories');
    }
};
