<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturaMeioPagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_meio_pagamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facturas_id')->constrainted();
            $table->foreignId('meios_pagamentos_id')->constrainted();
            $table->decimal('valor', 10)->nullable()->default(0);
            $table->decimal('troco', 10, 0)->nullable()->default(0);
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
        Schema::dropIfExists('factura_meio_pagamentos');
    }
}
