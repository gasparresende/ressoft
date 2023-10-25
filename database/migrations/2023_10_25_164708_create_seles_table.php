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
        Schema::create('seles', function (Blueprint $table) {
            $table->integer('id', true);
            $table->decimal('valor_total', 10)->nullable()->default(0);
            $table->decimal('troco', 10)->nullable()->default(0);
            $table->dateTime('data_emissao')->nullable();
            $table->date('data_vencimento')->nullable();
            $table->integer('clientes_id')->nullable()->index('fk_vendas_clientes1_idx');
            $table->string('mes', 20)->nullable();
            $table->integer('ano')->nullable();
            $table->integer('caixas_id')->index('fk_Vendas_caixa1_idx');
            $table->string('hash', 256)->nullable();
            $table->integer('moedas_id')->nullable()->index('moedas_id');
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
        Schema::dropIfExists('seles');
    }
};
