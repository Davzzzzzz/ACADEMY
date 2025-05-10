<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens; // 🔥 Agregado aquí

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // 🔥 Agregado HasApiTokens


    protected $table = 'usuario';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'correo',
        'contrasena',
        'fecha_registro',
        'id_rol'
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
    ];

    /**
     * Laravel usará este método para obtener el campo contraseña personalizado.
     */
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    /**
     * Laravel usará este campo como identificador (en vez de 'email')
     */
    public function getAuthIdentifierName()
    {
        return 'correo';
    }

    // Relaciones

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id');
    }

    public function reportes()
    {
        return $this->hasMany(Reporte::class, 'id');
    }

    public function racha()
    {
        return $this->hasOne(Racha::class, 'id');
    }

    public function progresoUsuario()
    {
        return $this->hasMany(ProgresoUsuario::class, 'id');
    }
}
