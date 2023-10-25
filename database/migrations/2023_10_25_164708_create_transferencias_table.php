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
            $table->integer('id', true);
            $table->integer('status_envio_id')->index('status_envio_id');
            $table->integer('shops_id_origem')->index('loja_origem');
            $table->integer('shops_id_destino')->index('loja_destino');
            $table->date('data')->nullable();
            $table->unsignedBigInteger('users_envio')->nullable()->index('users_envio');
            $table->unsignedBigInteger('users_recebe')->nullable()->index('users_recebe');
            $table->unsignedBigInteger('users_rejeita')->nullable()->index('users_rejeita');
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
