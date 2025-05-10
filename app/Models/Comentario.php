<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    protected $table = 'comentarios';
    public $timestamps = false; // <- DESACTIVA los campos created_at y updated_at
    protected $fillable = ['id_usuario', 'foro_id', 'contenido', 'fecha_publicacion'];
    protected $casts = [
        'fecha_publicacion' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
    public function foro()
    {
        return $this->belongsTo(Foro::class, 'foro_id');
    }
}
