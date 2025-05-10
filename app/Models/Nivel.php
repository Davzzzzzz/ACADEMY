<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    use HasFactory;
    protected $table = 'niveles';
    protected $primaryKey = 'id_nivel';
    public $timestamps = false; // <- DESACTIVA los campos created_at y updated_at
    protected $fillable = ['nombre_nivel', 'descripcion'];
    protected $casts = [
        'nombre_nivel' => 'string',
    ];

    public function lecciones()
    {
        return $this->hasMany(Leccion::class, 'id_nivel');
    }
}
