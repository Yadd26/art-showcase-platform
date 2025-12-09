<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Enums\UserRole;
use App\Enums\ApprovalStatus;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@artshowcase.com',
            'password' => Hash::make('password'),
            'role' => UserRole::ADMIN,
            'approval_status' => ApprovalStatus::APPROVED,
            'display_name' => 'Administrator',
        ]);

        // Demo Member
        User::create([
            'name' => 'John Doe',
            'email' => 'member@artshowcase.com',
            'password' => Hash::make('password'),
            'role' => UserRole::MEMBER,
            'approval_status' => ApprovalStatus::APPROVED,
            'display_name' => 'John Doe',
            'bio' => 'Digital artist and photographer',
        ]);

        // Demo Curator (Approved)
        User::create([
            'name' => 'Jane Smith',
            'email' => 'curator@artshowcase.com',
            'password' => Hash::make('password'),
            'role' => UserRole::CURATOR,
            'approval_status' => ApprovalStatus::APPROVED,
            'display_name' => 'Jane Smith',
            'bio' => 'Art curator and event organizer',
        ]);

        // Demo Curator (Pending)
        User::create([
            'name' => 'Bob Wilson',
            'email' => 'curator.pending@artshowcase.com',
            'password' => Hash::make('password'),
            'role' => UserRole::CURATOR,
            'approval_status' => ApprovalStatus::PENDING,
            'display_name' => 'Bob Wilson',
        ]);
    }
}