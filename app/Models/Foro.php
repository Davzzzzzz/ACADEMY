<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foro extends Model
{
    use HasFactory;
    protected $table = 'foros';
    protected $primaryKey = 'id';
    protected $fillable = ['titulo', 'descripcion', 'fecha_creacion'];
    protected $casts = [
        'fecha_creacion' => 'datetime',
    ];

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_foros');
    }
    public function publicaciones()
{
    return $this->hasMany(Publicacion::class, 'foro_id', 'id_foros');
}

}
