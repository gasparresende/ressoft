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
        Schema::create('transferencias_produtos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('transferencias_id')->index('status_envio_id');
            $table->integer('products_id')->index('produto_transferencia_ibfk_1_idx');
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
        Schema::dropIfExists('transferencias_produtos');
    }
};
