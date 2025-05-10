<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Leccion;

class LeccionSeeder extends Seeder
{
    public function run()
    {
        $lecciones = [
            [
                'nombre' => 'Lección #1',
                'descripcion' => 'la, leche, la, gusta, al, niño, el, hombre, ella',
                'nivel' => 1,
            ],
            [
                'nombre' => 'Lección #2',
                'descripcion' => 'tú, comes, mi, niño, niña, pan, yo, como',
                'nivel' => 1,
            ],
            [
                'nombre' => 'Lección #3',
                'descripcion' => 'está, nuestras, mujeres, mujeres, él',
                'nivel' => 1,
            ],
            [
                'nombre' => 'Lección #4',
                'descripcion' => 'yo, camino, ella, rosa, nosotros, tú',
                'nivel' => 1,
            ],
        ];

        foreach ($lecciones as $leccion) {
            Leccion::create($leccion);
        }
    }
}
