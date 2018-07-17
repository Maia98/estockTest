<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TriggerTransferenciaMaterialV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE OR REPLACE FUNCTION public.sp_atualizaestoquetransferencia()
                        RETURNS trigger AS
                        \$transferencia_material\$
                        DECLARE 
                            contadorEntrada INT;
                            contadorSaida INT;
                            id_material INT; 
                        
                            id_transferencia INT; 
                            id_obra_entrada INT; 
                            id_almoxarifado_entrada INT; 
                            id_obra_saida INT; 
                            id_almoxarifado_saida INT; 
                        
                        
                            qtde_obra_origem FLOAT;
                            qtde_obra_destino FLOAT;
                            
                            qtde_entrada FLOAT;
                            qtde_saida FLOAT;
                        
                            registrarEntrada BOOLEAN;
                        
                        BEGIN
                        
                            registrarEntrada = FALSE;
                        
                            IF(TG_OP = 'INSERT') THEN
                            id_material = new.tipo_material_id; 
                            qtde_entrada = new.qtde;
                            qtde_saida = new.qtde * -1;
                            id_obra_saida = new.obra_origem_id; 
                            id_transferencia = new.transferencia_estoque_id;
                            ELSEIF(TG_OP = 'UPDATE') THEN
                            RAISE 'OPERAÇÃO NÃO PERMITIDA.';
                            ELSEIF(TG_OP = 'DELETE') THEN
                            id_material = old.tipo_material_id; 
                            qtde_entrada = old.qtde * -1;
                            qtde_saida = old.qtde;
                            id_obra_saida = old.obra_origem_id; 
                            id_transferencia = old.transferencia_estoque_id;
                            END IF;
                        
                            SELECT obra_destino_id, almoxarifado_destino_id, almoxarifado_origem_id INTO id_obra_entrada, id_almoxarifado_entrada, id_almoxarifado_saida FROM transferencia_estoque WHERE id = id_transferencia;
                            
                            IF id_obra_entrada > 0 AND id_almoxarifado_entrada > 0 AND id_almoxarifado_saida > 0 THEN
                        
                            SELECT INTO contadorSaida count(*)  FROM estoque WHERE tipo_material_id = id_material AND almoxarifado_id = id_almoxarifado_saida AND obra_id = id_obra_saida;
                        
                            IF contadorSaida > 0 THEN
                        
                                IF(TG_OP = 'INSERT') THEN
                                    SELECT qtde INTO qtde_obra_origem FROM estoque WHERE tipo_material_id = id_material AND almoxarifado_id = id_almoxarifado_saida AND obra_id = id_obra_saida;
                                    new.qtde_obra_origem = qtde_obra_origem;
                                END IF;
                                
                                UPDATE estoque SET qtde = qtde + qtde_saida WHERE tipo_material_id = id_material AND almoxarifado_id = id_almoxarifado_saida AND obra_id = id_obra_saida;
                                registrarEntrada = TRUE;
                            END IF;
                        
                            ELSE
                            RAISE 'OBRAS E/OU ALMOXARIFADOS NÃO ENCONTRADOS! (ALMOXARIFADO ENTRADA: %, OBRA ENTRADA: %, ALMOXARIFADO SAIDA: % OBRA SAIDA: %)', id_almoxarifado_entrada, id_obra_entrada, id_almoxarifado_saida, id_obra_saida;
                            END IF;
                        
                            IF registrarEntrada = TRUE THEN
                            
                            SELECT INTO contadorEntrada count(*)  FROM estoque WHERE tipo_material_id = id_material AND almoxarifado_id = id_almoxarifado_entrada AND obra_id = id_obra_entrada;
                        
                            IF(TG_OP = 'INSERT') THEN
                                SELECT qtde INTO qtde_obra_destino FROM estoque WHERE tipo_material_id = id_material AND almoxarifado_id = id_almoxarifado_entrada AND obra_id = id_obra_entrada;
                                new.qtde_obra_destino = qtde_obra_destino;
                            END IF;
                            
                            IF contadorEntrada > 0 THEN
                                UPDATE estoque SET qtde = qtde + qtde_entrada WHERE tipo_material_id = id_material AND almoxarifado_id = id_almoxarifado_entrada AND obra_id = id_obra_entrada;
                            ELSE
                                INSERT INTO estoque (tipo_material_id, qtde, almoxarifado_id, obra_id) VALUES (id_material, qtde_entrada, id_almoxarifado_entrada, id_obra_entrada);
                            END IF;	    	
                            END IF;
                            
                            IF(TG_OP = 'DELETE') THEN
                                RETURN old;
                            ELSE 
                                RETURN new;
                            END IF;
                        
                            RETURN NULL;
                        END;
                        
                        \$transferencia_material\$ LANGUAGE plpgsql;");

        DB::unprepared("DROP TRIGGER IF EXISTS transferencia_material ON transferencia_material_estoque;");

        DB::unprepared("CREATE TRIGGER transferencia_material
                        BEFORE INSERT OR UPDATE OR DELETE ON transferencia_material_estoque
                            FOR EACH ROW EXECUTE PROCEDURE SP_AtualizaEstoqueTransferencia();");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("CREATE OR REPLACE FUNCTION SP_AtualizaEstoqueTransferencia() 
                        RETURNS TRIGGER AS \$transferencia_material\$
                        DECLARE 
                            contadorEntrada INT;
                            contadorSaida INT;
                            id_material INT; 

                            id_transferencia INT; 
                            id_obra_entrada INT; 
                            id_almoxarifado_entrada INT; 
                            id_obra_saida INT; 
                            id_almoxarifado_saida INT; 

                            qtde_entrada FLOAT;
                            qtde_saida FLOAT;

                            registrarEntrada BOOLEAN;

                        BEGIN

                            registrarEntrada = FALSE;

                            IF(TG_OP = 'INSERT') THEN
                                id_material = new.tipo_material_id; 
                                qtde_entrada = new.qtde;
                                qtde_saida = new.qtde * -1;
                                id_obra_saida = new.obra_origem_id; 
                                id_transferencia = new.transferencia_estoque_id;
                            ELSEIF(TG_OP = 'UPDATE') THEN
                                id_material = new.tipo_material_id; 
                                qtde_entrada = new.qtde - old.qtde;
                                qtde_saida = old.qtde - new.qtde;
                                id_obra_saida = new.obra_origem_id; 
                                id_transferencia = new.transferencia_estoque_id;
                            ELSEIF(TG_OP = 'DELETE') THEN
                                id_material = old.obra_origem_id; 
                                qtde_entrada = old.qtde * -1;
                                qtde_saida = old.qtde;
                                id_obra_saida = old.obra_origem_id; 
                                id_transferencia = old.transferencia_estoque_id;
                            END IF;

                            SELECT obra_destino_id, almoxarifado_destino_id, almoxarifado_origem_id INTO id_obra_entrada, id_almoxarifado_entrada, id_almoxarifado_saida FROM transferencia_estoque WHERE id = id_transferencia;

                            IF id_obra_entrada > 0 AND id_almoxarifado_entrada > 0 AND id_almoxarifado_saida > 0 THEN
                                SELECT INTO contadorSaida count(*)  FROM estoque WHERE tipo_material_id = id_material AND almoxarifado_id = id_almoxarifado_saida AND obra_id = id_obra_saida;

                                IF contadorSaida > 0 THEN
                                    UPDATE estoque SET qtde = qtde + qtde_saida WHERE tipo_material_id = id_material AND almoxarifado_id = id_almoxarifado_saida AND obra_id = id_obra_saida;
                                    registrarEntrada = TRUE;
                                END IF;

                            ELSE
                            RAISE 'OBRAS E/OU ALMOXARIFADOS NÃO ENCONTRADOS! (ALMOXARIFADO ENTRADA: %, OBRA ENTRADA: %, ALMOXARIFADO SAIDA: % OBRA SAIDA: %)', id_almoxarifado_entrada, id_obra_entrada, id_almoxarifado_saida, id_obra_saida;
                            END IF;

                            IF registrarEntrada = TRUE THEN
                                
                                SELECT INTO contadorEntrada count(*)  FROM estoque WHERE tipo_material_id = id_material AND almoxarifado_id = id_almoxarifado_entrada AND obra_id = id_obra_entrada;

                                IF contadorEntrada > 0 THEN
                                    UPDATE estoque SET qtde = qtde + qtde_entrada WHERE tipo_material_id = id_material AND almoxarifado_id = id_almoxarifado_entrada AND obra_id = id_obra_entrada;
                                ELSE
                                    INSERT INTO estoque (tipo_material_id, qtde, almoxarifado_id, obra_id) VALUES (id_material, qtde_entrada, id_almoxarifado_entrada, id_obra_entrada);
                                END IF;	    	
                            END IF;


                            RETURN NULL;
                        END;

                        \$transferencia_material\$ LANGUAGE plpgsql;");

        DB::unprepared("DROP TRIGGER IF EXISTS transferencia_material ON transferencia_material_estoque;");

        DB::unprepared("CREATE TRIGGER transferencia_material
                        AFTER INSERT OR UPDATE OR DELETE ON transferencia_material_estoque
                            FOR EACH ROW EXECUTE PROCEDURE SP_AtualizaEstoqueTransferencia();");
    }
}
