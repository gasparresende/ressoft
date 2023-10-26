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
            $table->integer('numero');
            $table->decimal('total', 10, 2);
            $table->dateTime('data_emissao');
            $table->date('data_vencimento');
            $table->foreignId('clientes_id')->constrained();
            $table->string('mes');
            $table->integer('ano');
            $table->foreignId('moedas_id')->constrained();
            $table->boolean('status')->default(1);
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
