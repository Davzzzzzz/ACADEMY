<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Publicacion extends Model
{
    use HasFactory;

    protected $table = 'publicaciones';

    protected $fillable = [
        'id',
        'foro_id',
        'parent_id',
        'contenido',
        'id_usuario', // <-- ¡AGREGADO!
    ];

    /**
     * Relación con el usuario que publicó.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario'); // <-- CORREGIDO
    }

    /**
     * Relación con el foro al que pertenece la publicación.
     */
    public function foro()
    {
        return $this->belongsTo(Foro::class);
    }

    /**
     * Respuestas a esta publicación (hijos).
     */
    public function respuestas()
    {
        return $this->hasMany(Publicacion::class, 'parent_id');
    }

    /**
     * Publicación padre (si es una respuesta).
     */
    public function padre()
    {
        return $this->belongsTo(Publicacion::class, 'parent_id');
    }
}
