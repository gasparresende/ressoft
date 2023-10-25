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
        Schema::create('seles_products', function (Blueprint $table) {
            $table->integer('id', true);
            $table->decimal('desconto', 10)->nullable();
            $table->integer('seles_id')->index('fk_Vendas_has_produtos_Vendas1_idx');
            $table->integer('inventories_id')->index('fk_vendas_produtos_produtos1_idx');
            $table->integer('qtd')->default(0);
            $table->decimal('preco', 10)->nullable();
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
        Schema::dropIfExists('seles_products');
    }
};
