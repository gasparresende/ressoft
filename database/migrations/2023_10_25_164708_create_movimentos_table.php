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
            $table->id();
            $table->decimal('debito', 10);
            $table->decimal('credito', 10);
            $table->string('razao', 445);
            $table->foreignId('contas_id')->nullable()->constrained();
            $table->dateTime('data_operacao')->nullable()->useCurrent();
            $table->date('data_movimento')->nullable();
            $table->foreignId('registos_id')->nullable()->constrained();
            $table->foreignId('users_id')->nullable()->constrained();
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
