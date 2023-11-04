<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContasBancariaEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contas_bancaria_empresas', function (Blueprint $table) {
            $table->id();
            $table->string('numero_conta_empresa');
            $table->string('iban_empresa');
            $table->foreignId('bancos_id')->constrained();
            $table->foreignId('empresas_id')->constrained();
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
        Schema::dropIfExists('contas_bancaria_empresas');
    }
}
