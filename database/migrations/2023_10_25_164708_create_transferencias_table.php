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
        Schema::create('transferencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('origem');
            $table->foreign('origem')->references('id')
                ->on('shops')->onUpdate('cascade');

            $table->unsignedBigInteger('destino');
            $table->foreign('destino')->references('id')
                ->on('shops')->onUpdate('cascade');
            $table->foreignId('products_id')->nullable()->constrained();
            $table->foreignId('sizes_id')->nullable()->constrained();
            $table->foreignId('colors_id')->nullable()->constrained();
            $table->foreignId('marcas_id')->nullable()->constrained();
            $table->foreignId('categorias_id')->nullable()->constrained();
            $table->foreignId('users_id')->nullable()->constrained();
            $table->date('validade')->nullable();
            $table->integer('qtd');
            $table->text('motivo')->nullable();
            $table->date('data');
            $table->time('hora');
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
        Schema::dropIfExists('transferencias');
    }
};
