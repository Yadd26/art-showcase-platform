<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_id')->constrained('users')->onDelete('cascade');
            $table->morphs('reportable'); // bisa artwork atau comment
            $table->enum('reason', [
                'hate_speech',
                'plagiarism', 
                'inappropriate_content',
                'spam',
                'harassment',
                'other'
            ]);
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'dismissed', 'action_taken'])->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('admin_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            
            $table->index('status');
            $table->index('reporter_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};