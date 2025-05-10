<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Racha extends Model
{
    use HasFactory;
    protected $table = 'racha';
    protected $primaryKey = 'id_racha';
    public $timestamps = false; // <- DESACTIVA los campos created_at y updated_at
    protected $fillable = ['id_usuario', 'dias_consecutivos'];
    protected $casts = [
        'dias_consecutivos' => 'integer',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
