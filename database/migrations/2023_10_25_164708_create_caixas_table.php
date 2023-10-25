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
        Schema::create('caixas', function (Blueprint $table) {
            $table->integer('id', true);
            $table->tinyInteger('status');
            $table->date('data_caixa');
            $table->unsignedBigInteger('users_id')->index('fk_caixa_usuarios1_idx');
            $table->decimal('saldo_inicial', 10)->nullable()->default(0);
            $table->decimal('total', 10)->nullable()->default(0);
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
        Schema::dropIfExists('caixas');
    }
};
