<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('polla_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('polla_id')->constrained('pollas')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['polla_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('polla_user');
    }
};
