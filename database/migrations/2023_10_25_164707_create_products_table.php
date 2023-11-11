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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product', 145)->unique();
            $table->string('codigo')->nullable()->unique();
            $table->decimal('preco_venda', 10,2)->nullable();
            $table->decimal('preco_compra', 10,2)->nullable();
            $table->boolean('status')->nullable()->default(true);
            $table->string('tipo', 3)->nullable()->default('P');
            $table->boolean('isstock')->nullable()->default(true);
            $table->string('localizacao', 100)->nullable();
            $table->foreignId('regimes_id')->nullable()->constrained();
            $table->foreignId('unidades_id')->nullable()->constrained();
            $table->text('imagem')->nullable();
            $table->text('observacao')->nullable();
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
        Schema::dropIfExists('products');
    }
};
