<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    use HasFactory;

    protected $table = 'recurso'; // Nombre de la tabla en la BD
    protected $primaryKey = 'id_recurso'; // Clave primaria

    protected $fillable = [
        'id_leccion', 
        'tipo', 
        'url'
    ];

    protected $casts = [
        'tipo' => 'string',
    ];

    // Relación con Lecciones (Un recurso pertenece a una lección)
    public function leccion()
    {
        return $this->belongsTo(Leccion::class, 'id_leccion');
    }
}
