<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedidos_id')->constrained();
            $table->foreignId('status_id')->constrained('status');
            $table->foreignId('users_id')->nullable()->constrained();

            $table->dateTime('data');
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
        Schema::dropIfExists('pedidos_status');
    }
}
