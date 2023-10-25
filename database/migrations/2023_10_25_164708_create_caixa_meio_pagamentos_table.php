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
        Schema::create('caixa_meio_pagamentos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('caixas_id')->index('fk_caixas_has_meio_pagamento_caixas1_idx');
            $table->integer('meios_pagamentos_id')->index('fk_caixas_has_meio_pagamento_meio_pagamento1_idx');
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
        Schema::dropIfExists('caixa_meio_pagamentos');
    }
};
