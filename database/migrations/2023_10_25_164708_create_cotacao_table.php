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
        Schema::create('cotacao', function (Blueprint $table) {
            $table->integer('id', true);
            $table->decimal('valor_total', 10)->nullable();
            $table->decimal('troco', 10)->nullable();
            $table->dateTime('data_emissao')->nullable();
            $table->date('data_vencimento')->nullable();
            $table->integer('clientes_id')->index('clientes_id');
            $table->string('mes', 45)->nullable();
            $table->integer('ano')->nullable();
            $table->unsignedBigInteger('users_id')->index('users_id');
            $table->integer('moedas_id')->nullable()->default(1)->index('moedas_id');
            $table->string('hash', 256)->nullable();
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
        Schema::dropIfExists('cotacao');
    }
};
