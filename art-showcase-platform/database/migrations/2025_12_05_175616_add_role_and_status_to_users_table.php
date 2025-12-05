<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'member', 'curator'])->default('member')->after('email');
            $table->enum('status', ['active', 'pending', 'suspended'])->default('active')->after('role');
            $table->string('display_name')->nullable()->after('name');
            $table->text('bio')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('behance_url')->nullable();
            $table->string('website_url')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role', 
                'status', 
                'display_name', 
                'bio', 
                'profile_picture',
                'instagram_url',
                'behance_url',
                'website_url'
            ]);
        });
    }
};