<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DepartamentoCiudadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departamentos')->insert([
            ['id' => 1, 'nombre' => 'Antioquia'],
            ['id' => 2, 'nombre' => 'Cundinamarca'],
            ['id' => 3, 'nombre' => 'Valle del Cauca'],
            ['id' => 4, 'nombre' => 'Atlántico'],
            ['id' => 5, 'nombre' => 'Santander']
        ]);
        
        
        DB::table('ciudades')->insert([
            ['nombre' => 'Medellín', 'departamento_id' => 1],
            ['nombre' => 'Envigado', 'departamento_id' => 1],
            ['nombre' => 'Bogotá', 'departamento_id' => 2],
            ['nombre' => 'Soacha', 'departamento_id' => 2],
            ['nombre' => 'Cali', 'departamento_id' => 3],
            ['nombre' => 'Palmira', 'departamento_id' => 3],
            ['nombre' => 'Barranquilla', 'departamento_id' => 4],
            ['nombre' => 'Soledad', 'departamento_id' => 4],
            ['nombre' => 'Bucaramanga', 'departamento_id' => 5],
            ['nombre' => 'Floridablanca', 'departamento_id' => 5]
        ]);
    }
}
