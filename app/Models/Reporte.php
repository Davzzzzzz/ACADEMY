<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reporte extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reportes';
    protected $primaryKey = 'id_reporte';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'descripcion',
        'fecha_reporte'
    ];

    protected $dates = ['deleted_at']; // Necesario para SoftDeletes

    public function usuario()
    {
    return $this->belongsTo(Usuario::class, 'id_usuario', 'id');
    }

}
