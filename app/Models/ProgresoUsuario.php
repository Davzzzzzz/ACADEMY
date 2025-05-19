<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgresoUsuario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'progreso_usuario';
    protected $primaryKey = 'id_progreso';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_nivel',
        'id_leccion_actual',
        'ejercicios_completados'
    ];

    protected $casts = [
        'ejercicios_completados' => 'integer',
    ];

    protected $dates = ['deleted_at']; // para que funcione SoftDeletes

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
