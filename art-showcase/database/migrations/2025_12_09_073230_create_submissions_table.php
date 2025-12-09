<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('challenge_id')->constrained()->onDelete('cascade');
            $table->foreignId('artwork_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('winner_rank')->nullable(); // 1, 2, 3 untuk juara
            $table->timestamps();
            
            $table->unique(['challenge_id', 'artwork_id']);
            $table->index('challenge_id');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};