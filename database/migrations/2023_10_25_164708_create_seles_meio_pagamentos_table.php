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
        Schema::create('seles_meio_pagamentos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('seles_id')->index('fk_vendas_has_meio_pagamento_vendas1_idx');
            $table->integer('meio_pagamentos_id')->index('fk_vendas_has_meio_pagamento_meio_pagamento1_idx');
            $table->decimal('valor', 10)->nullable();
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
        Schema::dropIfExists('seles_meio_pagamentos');
    }
};
