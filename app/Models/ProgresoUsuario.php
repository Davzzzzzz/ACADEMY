<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgresoUsuario extends Model
{
    use HasFactory;
    protected $table = 'progreso_usuario';
    protected $primaryKey = 'id_progreso';
    protected $fillable = ['id_usuario', 'id_nivel', 'id_leccion_actual', 'ejercicios_completados'];
    protected $casts = [
        'ejercicios_completados' => 'integer',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
    public function nivel()
    {
        return $this->belongsTo(Nivel::class, 'id_nivel');
    }
    public function leccion()
    {
        return $this->belongsTo(Leccion::class, 'id_leccion_actual');
    }
}
