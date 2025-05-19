<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Racha extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'racha';
    protected $primaryKey = 'id_racha';
    public $timestamps = false;

    protected $fillable = [
    'id_usuario',
    'dias_consecutivos',
    'ultima_fecha',
];

    protected $casts = [
        'dias_consecutivos' => 'integer',
    ];

    protected $dates = ['deleted_at']; // importante para SoftDeletes

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
