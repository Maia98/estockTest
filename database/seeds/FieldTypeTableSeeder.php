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
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
        
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

<<<<<<< HEAD
=======
=======
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
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
