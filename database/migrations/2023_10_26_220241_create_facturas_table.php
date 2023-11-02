<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->integer('numero')->nullable()->default(1);
            $table->decimal('valor_total', 10, 2)->nullable();
            $table->dateTime('data_emissao')->nullable();
            $table->date('data_vencimento')->nullable();
            $table->foreignId('clientes_id')->constrained()->onUpdate('cascade');
            $table->string('mes', 45)->nullable();
            $table->integer('ano')->nullable();
            $table->foreignId('users_id')->nullable()->constrained()->onUpdate('cascade');
            $table->foreignId('moedas_id')->nullable()->constrained()->onUpdate('cascade');
            $table->integer('status')->nullable()->default(1);
            $table->string('hash', 256)->nullable();
            $table->decimal('retencao', 10, 2)->nullable();
            $table->string('motivo_nc', 100)->nullable();
            $table->boolean('tipo')->nullable()->default(false);
            $table->foreignId('tipos_id')->nullable()->constrained()->onUpdate('cascade');
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
        Schema::dropIfExists('facturas');
    }
}
