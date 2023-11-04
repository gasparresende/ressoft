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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nome_empresa', 205);
            $table->string('nif_empresa', 95)->nullable()->unique();
            $table->string('telemovel_empresa', 45)->nullable();
            $table->string('email_empresa', 105)->nullable();
            $table->string('logotipo_empresa', 500)->nullable();
            $table->string('endereco_empresa', 145)->nullable();
            $table->string('website_empresa', 145)->nullable();
            $table->foreignId('regimes_id')->nullable()->constrained();
            $table->foreignId('taxas_id')->nullable()->constrained();
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
        Schema::dropIfExists('empresas');
    }
};
