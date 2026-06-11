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
        Schema::table('polla_user', function (Blueprint $table) {
            $table->unsignedTinyInteger('marcador_local')->nullable()->after('user_id');
            $table->unsignedTinyInteger('marcador_visitante')->nullable()->after('marcador_local');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('polla_user', function (Blueprint $table) {
            $table->dropColumn(['marcador_local', 'marcador_visitante']);
        });
    }
};
