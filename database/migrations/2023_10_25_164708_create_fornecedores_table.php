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
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nome', 145)->unique('nome_fornecedores_UNIQUE');
            $table->string('nif', 45)->unique('nif_fornecedores_UNIQUE');
            $table->string('telemovel', 45)->nullable();
            $table->string('email', 45)->nullable();
            $table->string('endereco', 245)->nullable();
            $table->integer('contas_id')->nullable()->index('fk_contas_f_idx');
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
        Schema::dropIfExists('fornecedores');
    }
};
