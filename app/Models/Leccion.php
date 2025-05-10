<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leccion extends Model
{
    use HasFactory;
    protected $table = 'lecciones';
    protected $primaryKey = 'id_leccion';
    public $timestamps = false; // <- DESACTIVA los campos created_at y updated_at
    protected $fillable = ['id_nivel', 'titulo', 'contenido'];
    public function nivel()
    {
        return $this->belongsTo(Nivel::class, 'id_nivel');
    }
    public function ejercicios()
    {
        return $this->hasMany(Ejercicio::class, 'id_leccion');
    }
}
