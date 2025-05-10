<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
    use HasFactory;

    protected $table = 'ejercicios';
    protected $primaryKey = 'id_ejercicio';
    public $timestamps = false; // <- DESACTIVA los campos created_at y updated_at

    protected $fillable = [
        'id_leccion',
        'id_tipo_pregunta',
        'pregunta',
        'imagen_pregunta', // ✅ Campo nuevo agregado aquí
        'opciones',
        'respuesta_correcta'
    ];

    protected $casts = [
        'opciones' => 'array',
    ];

    public function leccion()
    {
        return $this->belongsTo(Leccion::class, 'id_leccion');
    }
}
