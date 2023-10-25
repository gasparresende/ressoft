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
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nome', 45);
            $table->string('bi', 45);
            $table->date('data_emissao')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('local_emissao', 145)->nullable();
            $table->string('numero_inss', 45)->nullable();
            $table->string('endereco', 245)->nullable();
            $table->string('naturalidade', 145)->nullable();
            $table->float('salario', 10, 0)->nullable();
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
        Schema::dropIfExists('funcionarios');
    }
};
