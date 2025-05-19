<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comentario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'comentarios';
    public $timestamps = false; // <- Conservamos tu configuración

    protected $fillable = ['id_usuario', 'foro_id', 'contenido', 'fecha_publicacion'];

    protected $casts = [
        'fecha_publicacion' => 'datetime',
    ];

    protected $dates = ['deleted_at']; // Necesario para SoftDeletes

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function foro()
    {
        return $this->belongsTo(Foro::class, 'foro_id');
    }
}
