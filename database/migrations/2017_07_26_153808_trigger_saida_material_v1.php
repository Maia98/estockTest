<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TriggerSaidaMaterialV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE OR REPLACE FUNCTION SP_AtualizaEstoqueSaida() 
                        RETURNS TRIGGER AS \$saida_material\$
                        DECLARE 
                            contador INT;
                            id_material INT; 
                            id_obra INT; 
                            id_almoxarifado INT; 
                            id_saida INT; 
                            qtde_saida FLOAT;
                        BEGIN

                                IF(TG_OP = 'INSERT') THEN
                                        id_material = new.tipo_material_id; 
                                        id_saida = new.saida_estoque_id; 
                                        qtde_saida = new.qtde * -1;
                                ELSEIF(TG_OP = 'UPDATE') THEN
                                        id_material = new.tipo_material_id; 
                                        id_saida = new.saida_estoque_id; 
                                        qtde_saida = old.qtde - new.qtde;
                                ELSEIF(TG_OP = 'DELETE') THEN
                                        id_material = old.tipo_material_id; 
                                        id_saida = old.saida_estoque_id; 
                                        qtde_saida = old.qtde;
                                END IF;

                                SELECT obra_id, almoxarifado_id INTO id_obra, id_almoxarifado FROM saida_estoque WHERE id = id_saida;

                                IF id_obra > 0 AND id_almoxarifado > 0 THEN
                                        SELECT INTO contador count(*)  FROM estoque WHERE tipo_material_id = id_material AND obra_id = id_obra AND almoxarifado_id = id_almoxarifado;

                                        IF contador > 0 THEN
                                                UPDATE estoque SET qtde = qtde + qtde_saida WHERE tipo_material_id = id_material AND obra_id = id_obra AND almoxarifado_id = id_almoxarifado;
                                        ELSE
                                                RAISE 'MATERIAL NÃO ENCONTRADO NO ESTOQUE!';
                                        END IF;
                                ELSE
                                        RAISE 'OBRA E/OU ALMOXARIFADO NÃO ENCONTRADO! (%, %)', id_obra, id_almoxarifado;
                                END IF;

                                RETURN NULL;

                        END;

                        \$saida_material\$ LANGUAGE plpgsql;");
                
        DB::unprepared("DROP TRIGGER IF EXISTS saida_material ON saida_material_estoque;");
        
        DB::unprepared("CREATE TRIGGER saida_material
                        AFTER INSERT OR UPDATE OR DELETE ON saida_material_estoque
                            FOR EACH ROW EXECUTE PROCEDURE SP_AtualizaEstoqueSaida();");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS saida_material ON saida_material_estoque;");
    }
}
