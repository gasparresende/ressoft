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
        Schema::create('facturas_servicos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('desconto')->nullable();
            $table->integer('facturas_id')->index('fk_facturas_proforma');
            $table->integer('inventories_id')->index('fk_servicos');
            $table->integer('qtd')->nullable();
            $table->decimal('preco', 10)->nullable()->default(0);
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
        Schema::dropIfExists('facturas_servicos');
    }
};
