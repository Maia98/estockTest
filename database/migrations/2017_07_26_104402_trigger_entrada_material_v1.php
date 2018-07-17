<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TriggerEntradaMaterialV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE OR REPLACE FUNCTION SP_AtualizaEstoqueEntrada() 
                        RETURNS TRIGGER AS \$entrada_material\$
                        DECLARE 
                            contador INT;
                            id_material INT; 
                            id_obra INT; 
                            id_almoxarifado INT; 
                            id_entrada INT;
                            qtde_entrada FLOAT;
                        BEGIN

                                IF(TG_OP = 'INSERT') THEN
                                        id_material = new.tipo_material_id; 
                                        id_entrada = new.entrada_estoque_id; 
                                        qtde_entrada = new.qtde;
                                ELSEIF(TG_OP = 'UPDATE') THEN
                                        id_material = new.tipo_material_id; 
                                        id_entrada = new.entrada_estoque_id; 
                                        qtde_entrada = new.qtde - old.qtde;
                                ELSEIF(TG_OP = 'DELETE') THEN
                                        id_material = old.tipo_material_id; 
                                        id_entrada = old.entrada_estoque_id; 
                                        qtde_entrada = old.qtde * -1;
                                END IF;


                                SELECT obra_id, almoxarifado_id INTO id_obra, id_almoxarifado FROM entrada_estoque WHERE id = id_entrada;

                                IF id_obra > 0 AND id_almoxarifado > 0 THEN
                                        SELECT INTO contador count(*)  FROM estoque WHERE tipo_material_id = id_material AND obra_id = id_obra AND almoxarifado_id = id_almoxarifado;

                                        IF contador > 0 THEN
                                                UPDATE estoque SET qtde = qtde + qtde_entrada WHERE tipo_material_id = id_material AND obra_id = id_obra AND almoxarifado_id = id_almoxarifado;
                                        ELSE
                                                INSERT INTO estoque (tipo_material_id, obra_id, almoxarifado_id, qtde) VALUES (id_material, id_obra, id_almoxarifado, qtde_entrada);
                                        END IF;
                                ELSE
                                        RAISE 'OBRA E/OU ALMOXARIFADO NÃO ENCONTRADO! (%, %)', id_obra, id_almoxarifado;
                                END IF;

                                RETURN NULL;
                        END;

                        \$entrada_material\$ LANGUAGE plpgsql;");
                
        DB::unprepared("DROP TRIGGER IF EXISTS entrada_material ON entrada_material_estoque;");
        
        DB::unprepared("CREATE TRIGGER entrada_material
                        AFTER INSERT OR UPDATE OR DELETE ON entrada_material_estoque
                            FOR EACH ROW EXECUTE PROCEDURE SP_AtualizaEstoqueEntrada();");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS entrada_material ON entrada_material_estoque;");
    }
}
