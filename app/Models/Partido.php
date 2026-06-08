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
}
