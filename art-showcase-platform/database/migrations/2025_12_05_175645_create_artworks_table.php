<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artworks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('image_path'); // path file gambar
            $table->json('tags')->nullable(); // array tags
            $table->integer('views_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->enum('status', ['published', 'draft', 'taken_down'])->default('published');
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('category_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artworks');
    }
};