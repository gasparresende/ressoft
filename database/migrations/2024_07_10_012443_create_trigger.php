<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Criar Procedure
        DB::unprepared('
            CREATE PROCEDURE `actualizar_stock`(IN shops_id2 INT, IN sizes_id2 INT, IN colors_id2 INT,
                                                           IN marcas_id2 INT, IN categorias_id2 INT,
                                                           IN products_id2 INT, IN qtd2 INT, IN validade2 DATE)
            BEGIN
                DECLARE inventories_id INT(11);

                SELECT id INTO inventories_id
                FROM inventories
                WHERE products_id = products_id2
                  AND shops_id = shops_id2
                  AND (sizes_id = sizes_id2 OR sizes_id IS NULL AND sizes_id2 IS NULL)
                  AND (colors_id = colors_id2 OR colors_id IS NULL AND colors_id2 IS NULL)
                    AND (marcas_id = marcas_id2 OR marcas_id IS NULL AND marcas_id2 IS NULL)
                    AND (categorias_id = categorias_id2 OR categorias_id IS NULL AND categorias_id2 IS NULL)
                    AND (validade = validade2 OR validade IS NULL AND validade2 IS NULL);


                 IF inventories_id IS NOT NULL THEN
                    UPDATE inventories
                    SET qtd = qtd + qtd2
                    WHERE id = inventories_id;
                ELSE
                    INSERT INTO inventories(products_id, qtd, shops_id, sizes_id, colors_id, marcas_id, categorias_id, validade)
                    VALUES (products_id2, qtd2, shops_id2, sizes_id2, colors_id2, marcas_id2, categorias_id2, validade2);
                END IF;
            END'
        );

        //criar trigger actualizar_after_insert_entradas
        DB::unprepared('
        CREATE TRIGGER `actualizar_after_insert_entradas` AFTER INSERT ON `entradas`
            FOR EACH ROW BEGIN
                CALL actualizar_stock(new.shops_id, new.sizes_id, new.colors_id, new.marcas_id,
	                new.categorias_id, new.products_id, new.qtd, new.validade);
	        END;'
        );

        //criar trigger actualizar_after_insert_saidass
        DB::unprepared('
        CREATE TRIGGER `actualizar_after_insert_saidass` AFTER INSERT ON `saidas`
            FOR EACH ROW BEGIN
                CALL actualizar_stock(new.shops_id, new.sizes_id, new.colors_id, new.marcas_id,
	                new.categorias_id, new.products_id, new.qtd*(-1), new.validade);
            END;'
        );

        //criar trigger transferencias_after_insert
        DB::unprepared('
        CREATE TRIGGER `transferencias_after_insert` AFTER INSERT ON `transferencias`
            FOR EACH ROW BEGIN
                INSERT INTO saidas
                    (products_id, shops_id, sizes_id, colors_id, marcas_id, categorias_id, qtd, validade, DATA, obs, users_id, hora)
                VALUES
                    (new.products_id, new.origem, new.sizes_id, new.colors_id, new.marcas_id, new.categorias_id, new.qtd, new.validade, new.data, "Saidass de Transferência", new.users_id, now());

                INSERT INTO entradas
                    (products_id, shops_id, sizes_id, colors_id, marcas_id, categorias_id, qtd, validade, DATA, obs, users_id, hora)
                VALUES
                    (new.products_id, new.destino, new.sizes_id, new.colors_id, new.marcas_id, new.categorias_id, new.qtd, new.validade, new.data, "Entradas de Transferência", new.users_id, now());
            END;'
        );

        //Criar Trigger para Dar baixa no Stock
        DB::unprepared('
        CREATE TRIGGER `actualizar_after_insert_pedidos_products` AFTER INSERT ON `pedidos_products`
            FOR EACH ROW BEGIN
                 CREATE TRIGGER `actualizar_after_insert_pedidos_products` AFTER INSERT ON `pedidos_products`
            FOR EACH ROW BEGIN
                UPDATE inventories set qtd = qtd - NEW.qtd
                where id = new.inventories_id;
	        END;

	        END;'
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE `actualizar_stock`');
        DB::unprepared('DROP TRIGGER `actualizar_after_insert_entradas`');
        DB::unprepared('DROP TRIGGER `actualizar_after_insert_saidass`');
        DB::unprepared('DROP TRIGGER `transferencias_after_insert`');
        DB::unprepared('DROP TRIGGER `actualizar_after_insert_pedidos_products`');
    }
};
