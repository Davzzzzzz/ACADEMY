<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPregunta extends Model
{
    use HasFactory;
    protected $table = 'tipo_pregunta';
    public $timestamps = false; // <- DESACTIVA los campos created_at y updated_at
    protected $primaryKey = 'id_tipo_pregunta';
    protected $fillable = ['tipo', 'respuesta_correcta'];
}

