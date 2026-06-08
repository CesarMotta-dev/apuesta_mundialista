<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('partidos', function (Blueprint $table) {
            $table->id();
            $table->string('equipo_local');
            $table->string('equipo_visitante');

            // Este es tu "tiempo de plazo". Guardará la fecha y hora exacta del partido.
            $table->dateTime('fecha_inicio');

            // Para cuando n8n o tú como admin actualicen los resultados reales
            $table->integer('goles_local')->nullable();
            $table->integer('goles_visitante')->nullable();

            // Estados: 'pendiente', 'jugándose', 'finalizado'
            $table->string('estado')->default('pendiente');

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partidos');
    }
};
