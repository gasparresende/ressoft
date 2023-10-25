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
        Schema::create('contas_bancaria_empresas', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('numero_conta_empresa', 145);
            $table->string('iban_empresa', 245);
            $table->integer('bancos_id')->index('fk_contas_bancaria_empresa_bancos1_idx');
            $table->integer('empresas_id')->index('fk_contas_bancaria_empresa_empresas1_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contas_bancaria_empresas');
    }
};
