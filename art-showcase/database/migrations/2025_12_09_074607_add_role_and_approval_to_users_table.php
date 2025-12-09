<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\UserRole;
use App\Enums\ApprovalStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default(UserRole::MEMBER->value)->after('email');
            $table->string('approval_status')->default(ApprovalStatus::APPROVED->value)->after('role');
            $table->text('bio')->nullable()->after('approval_status');
            $table->string('display_name')->nullable()->after('bio');
            $table->string('profile_photo')->nullable()->after('display_name');
            $table->string('external_link')->nullable()->after('profile_photo');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'approval_status', 'bio', 'display_name', 'profile_photo', 'external_link']);
        });
    }
};