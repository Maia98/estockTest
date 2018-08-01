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
        
        DB::table('field_types')->insert([
            ['desc' => 'Resposta curta', 'value' => 'text'],
            ['desc' => 'Resposta longa', 'value' => 'textarea'],
            ['desc' => 'Hora', 'value' => 'time'],
            ['desc' => 'Data', 'value' => 'date'],
            ['desc' => 'Data e Hora', 'value' => 'datetime'],
            ['desc' => 'Upload de Arquivo', 'value' => 'file'],
            ['desc' => 'Numérico', 'value' => 'number']

        ]);
    }
}

