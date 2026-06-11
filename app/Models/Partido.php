<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
    protected $fillable = [
        'equipo_local',
        'equipo_visitante',
        'fecha_inicio',
        'goles_local',
        'goles_visitante',
        'estado'
    ];

    // Esto ayuda a Laravel a tratar fecha_inicio como un objeto Carbon automáticamente
    protected $casts = [
        'fecha_inicio' => 'datetime',
    ];

    // Opcional: relación con el modelo Apuesta
    public function apuestas()
    {
        return $this->hasMany(Apuesta::class);
    }

    public function pollas()
    {
        return $this->hasMany(Polla::class);
    }

}
