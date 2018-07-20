<?php

use Illuminate\Database\Seeder;

class FieldTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('field_types')->insert(
            ['desc' => 'Resposta curta', 'value' => 'text'],
            ['desc' => 'Resposta longa', 'value' => 'memo'],
            ['desc' => 'Data e Hora', 'value' => 'datetime'],
            ['desc' => 'Número do Telefone', 'value' => 'phone'],
            ['desc' => 'Caixa de seleção', 'value' => 'bool'],
            ['desc' => 'Upload de Arquivo', 'value' => 'files'],
            ['desc' => 'Quebra de Seção', 'value' => 'break'],
            ['desc' => 'Informações', 'value' => 'info'],
            ['desc' => 'Radiobuttons', 'value' => 'radiobutton']
        );
    }
}
