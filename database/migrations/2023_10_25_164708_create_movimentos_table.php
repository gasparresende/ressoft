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
        Schema::create('movimentos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->decimal('debito', 10);
            $table->decimal('credito', 10);
            $table->string('razao', 445);
            $table->integer('contas_id')->index('contas_id');
            $table->dateTime('data_operacao')->nullable()->useCurrent();
            $table->date('data_movimento')->nullable();
            $table->integer('facturas_id')->nullable()->index('facturas_id');
            $table->unsignedBigInteger('users_id')->nullable()->index('users_id');
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
        Schema::dropIfExists('movimentos');
    }
};
