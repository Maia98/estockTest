<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['id' => 1,
                'name' => 'ADMINISTRADOR',
                'description' => 'Administrador do sistema'],
            ['id' => 2,
                'name' => 'ALMOXARIFE',
                'description' => 'Almoxarifado'],
            ['id' => 3,
                'name' => 'CONSULTA',
                'description' => 'Consulta'],
            ['id' => 4,
                'name' => 'MEDICAO',
                'description' => 'Medição'],
            ['id' => 5,
                'name' => 'OPERACIONAL',
                'description' => 'Operacional'
            ]
        ]);
    }
}
