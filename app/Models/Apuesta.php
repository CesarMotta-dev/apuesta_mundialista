<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apuesta extends Model
{
    // En app/Models/Apuesta.php
public function partido()
{
    return $this->belongsTo(Partido::class);

}
    protected $fillable = ['user_id', 'partido_id', 'polla_id', 'marcador_local', 'marcador_visitante'];
}
