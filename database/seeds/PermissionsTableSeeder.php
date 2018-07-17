<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            ['id' => 1,  'name' => 'CONSULTAR_OBRA', 'description' => 'VISUALIZA GERENCIADOR OBRA'],
            ['id' => 2,  'name' => 'EXPORTAR_CONSULTA_OBRA', 'description' => 'EXPORTA OS ARQUIVOS DE EXCEL E PDF DOS REGISTRO DE OBRA'],
            ['id' => 3,  'name' => 'CADASTRAR_OBRA', 'description' => 'CADASTRA REGISTROS DE OBRA'],
            ['id' => 4,  'name' => 'CADASTRAR_HISTORICO_OBRA', 'description' => 'INSERI REGISTRO NO HISTÓRICO DA OBRA'],
            ['id' => 5,  'name' => 'CONSULTAR_HISTORICO_OBRA', 'description' => 'VISUALIZA O HISTÓRICO DA OBRA'],
            ['id' => 6,  'name' => 'EXPORTAR_HISTORICO_OBRA', 'description' => 'EXPORTA OS ARQUIVOS DE EXCEL E PDF DO HISTÓRICO DA OBRA'],
            ['id' => 7,  'name' => 'CONSULTAR_BALANCO_OBRA', 'description' => 'VISUALIZA BALANÇO DA OBRA'],
            ['id' => 8,  'name' => 'EXPORTAR_BALANCO_OBRA', 'description' => 'EXPORATA OS ARQUIVOS DE EXCEL E PDF DO HISTÓRICO DA OBRA'],
            ['id' => 9,  'name' => 'CONSULTAR_DETALHES_OBRA', 'description' => 'VISUALIZA OS DETALHES DA OBRA'],
            ['id' => 10, 'name' => 'EXPORTAR_LISTAO_MAT_ORCADO', 'description' => 'EXPORTA LISTÃO DOS MATERIAIS ORÇADOS.'],
            ['id' => 11, 'name' => 'CADASTRAR_ENTRADA_ESTOQUE', 'description' => 'CADASTRA ENTRADA ESTOQUE'],
            ['id' => 12, 'name' => 'CONSULTAR_ENTRADA_ESTOQUE', 'description' => 'VISUALIZA REGISTROS DE ENTRADA ESTOQUE'],
            ['id' => 13, 'name' => 'EXPORTAR_COSULTA_ENTRADA_ESTOQUE', 'description' => 'EXPORATA OS ARQUIVOS DE EXCEL E PDF DOS REGISTRO DE ENTRADA ESTOQUE'],
            ['id' => 14, 'name' => 'CONSULTAR_LISTA_ENTRADA_ESTOQUE', 'description' => 'VISUALIZA LISTA DOS REGISTROS DE MATERIAS DE ENTRADA ESTOQUE'],
            ['id' => 15, 'name' => 'EXPORTAR_LISTA_ENTRADA_ESTOQUE', 'description' => 'EXPORATA OS ARQUIVOS DE EXCEL E PDF DAS LISTAS DE REGISTRO ENTRADA ESTOQUE'],
            ['id' => 16, 'name' => 'CADASTRAR_TRANSFERENCIA_ESTOQUE', 'description' => 'CADASTRA REGISTROS DE TRANFERÊNCIA ESTOQUE'],
            ['id' => 17, 'name' => 'CONSULTAR_TRANSFERENCIA_ESTOQUE', 'description' => 'VISUALIZA REGISTROS DE TRANSFERÊNCIAS ESTOQUE'],
            ['id' => 18, 'name' => 'EXPORTAR_TRANSFERENCIA_ESTOQUE', 'description' => 'EXPORATA OS ARQUIVOS DE EXCEL E PDF DOS REGISTRO TRANSFERÊNCIA ESTOQUE'],
            ['id' => 19, 'name' => 'CONSULTAR_LISTA_TRANSFERENCIA_ESTOQUE', 'description' => 'VISUALIZA LISTA DOS REGISTROS DE TRANSFERÊNCIA ESTOQUE'],
            ['id' => 20, 'name' => 'EXPORTAR_LISTA_TRANSFERENCIA_ESTOQUE', 'description' => 'EXPORATA OS ARQUIVOS DE EXCEL E PDF DAS LISTAS DE REGISTRO TRANSFERÊNCIA ESTOQUE'],
            ['id' => 21, 'name' => 'CADASTRAR_SAIDA_ESTOQUE', 'description' => 'CADASTRA SAÍDA ESTOQUE'],
            ['id' => 22, 'name' => 'CONSULTAR_SAIDA_ESTOQUE', 'description' => 'VISUALIZA REGISTROS DE SAÍDA ESTOQUE'],
            ['id' => 23, 'name' => 'EXPORTAR_CONSULTA_SAIDA_ESTOQUE', 'description' => 'EXPORATA OS ARQUIVOS DE EXCEL E PDF DOS REGISTRO DE SAÍDA ESTOQUE'],
            ['id' => 24, 'name' => 'CONSULTAR_LISTA_SAIDA_ESTOQUE', 'description' => 'VISUALIZA LISTA DOS REGISTROS DE SAÍDA ESTOQUE'],
            ['id' => 25, 'name' => 'EXPORTAR_LISTA_SAIDA_ESTOQUE', 'description' => 'EXPORATA OS ARQUIVOS DE EXCEL E PDF DAS LISTAS DE REGISTRO SAÍDA ESTOQUE'],
            ['id' => 26, 'name' => 'CADASTRAR_MEDICAO', 'description' => 'CADASTRA MEDIÇÃO DE MÃO DE OBRA'],
            ['id' => 27, 'name' => 'CONSULTAR_MEDICAO', 'description' => 'VISUALIZA REGISTROS DE  MEDIÇÃO DE MÃO DE OBRA'],
            ['id' => 28, 'name' => 'EXPORTAR_CONSULTA_MEDICAO', 'description' => 'EXPORATA OS ARQUIVOS DE EXCEL E PDF DOS REGISTRO DE MEDIÇÃO DE MÃO DE OBRA'],
            ['id' => 29, 'name' => 'CONSULTAR_DETALHES_MEDICAO', 'description' => 'VISUALIZA DETALHES DA MEDIÇÃO DE MÃO DE OBRA'],
            ['id' => 30, 'name' => 'EXPORTAR_DETALHES_MEDICAO', 'description' => 'EXPORATA OS ARQUIVOS DE EXCEL E PDF DOS REGISTRO DE DETALHES DE MEDIÇÃO DE MÃO DE OBRA'],
            ['id' => 31, 'name' => 'ALTERAR_US_MEDICAO', 'description' => 'ALTERA VALOR DE US DA MEDIÇÃO DE MÃO DE OBRA'],
            ['id' => 32, 'name' => 'CONSULTAR_ESTOQUE', 'description' => 'VISUALIZA QUANTITATIVOS DOS MATERIAS EM ESTOQUE POR ALMOXARIFADO'],
            ['id' => 33, 'name' => 'EXPORTAR_ESTOQUE', 'description' => 'EXPORATA OS ARQUIVOS DE EXCEL E PDF DOS REGISTRO DE DETALHES DE MEDIÇÃO DE MÃO DE OBRA'],
            ['id' => 34, 'name' => 'CONSULTAR_PESQUISA_ESTOQUE', 'description' => 'VISUALIZA PESQUISA DE MATERIAIS ESTOQUE'],
            ['id' => 35, 'name' => 'EXPORTAR_PESQUISA_ESTOQUE', 'description' => 'EXPORTAR PESQUISA DE MATEIAL ESTOQUE'],
            ['id' => 36, 'name' => 'CONSULTAR_TABELAS_SISTEMA', 'description' => 'VISUALIZA REGISTROS CONTIDOS NAS TABELAS DO SISTEMA'],
            ['id' => 37, 'name' => 'CADASTRAR_TABELAS_SISTEMA', 'description' => 'CADASTRA REGISTROS NAS TABELAS DO SISTEMA'],
            ['id' => 38, 'name' => 'EXCLUIR_TABELAS_SISTEMA', 'description' => 'EXCLUI REGISTROS NAS TABELAS DO SISTEMAS'],
            ['id' => 39, 'name' => 'CADASTRAR_USUARIO', 'description' => 'CADASTRA USUÁRIO DO SISTEMA '],
            ['id' => 40, 'name' => 'CONSULTAR_USUARIO', 'description' => 'VISUALIZA REGISTRO DE USUÁRIOS DO SISTEMA'],
            ['id' => 41, 'name' => 'CONSULTAR_FUNCAO', 'description' => 'CONSULTA REGISTROS DE FUNÇÃO DE PERFIL DO SISTEMA '],
            ['id' => 42, 'name' => 'CADASTRAR_FUNCAO', 'description' => 'CADASTRA A FUNÇÃO DE UM USUÁRIO NO SISTEMA'],
            ['id' => 43, 'name' => 'CONSULTAR_EMPRESA', 'description' => 'VISUALIZA INFORMAÇÕES CADASTRAIS DA EMPRESA'],
            ['id' => 44, 'name' => 'ALTERAR_EMPRESA', 'description' => 'ALTERAR DADOS CADASTRAIS DA EMPRESA'],
            ['id' => 45, 'name' => 'CONSULTAR_GERENCIAL', 'description' => 'VISUALIZA GRÁFICOS DA PARTE GERENCIAL DO SISTEMA']
        ]);
    }
}
