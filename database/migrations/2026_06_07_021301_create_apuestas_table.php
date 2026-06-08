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
        Schema::create('apuestas', function (Blueprint $table) {
            $table->id();

            // Relación con el usuario (quién hace la apuesta)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Relación con el partido (a qué partido le apuesta)
            $table->foreignId('partido_id')->constrained()->onDelete('cascade');

            // La predicción exacta (el "marcador" que mencionas en tu papel)
            $table->integer('goles_local_prediccion');
            $table->integer('goles_visitante_prediccion');

            // Cuánto dinero apostó
            $table->decimal('monto', 10, 2);

            // Estado de la apuesta ('pendiente', 'ganada', 'perdida')
            $table->string('estado')->default('pendiente');

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apuestas');
    }
};
