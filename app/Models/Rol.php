<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre'];
    public function permisos(){
    return $this->belongsToMany(Permiso::class, 'rol_permiso', 'id', 'id_permiso');
    }

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id_rol');
    }
}
