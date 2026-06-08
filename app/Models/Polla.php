<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Polla extends Model
{
    protected $fillable = [
        'administrador_id',
        'nombre',
        'descripcion',
        'monto',
        'estado',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
    ];

    public function administrador()
    {
        return $this->belongsTo(User::class, 'administrador_id');
    }

    public function apostadores()
    {
        return $this->belongsToMany(User::class, 'polla_user')->withTimestamps();
    }
}
