<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case MEMBER = 'member';
    case CURATOR = 'curator';

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Admin',
            self::MEMBER => 'Member',
            self::CURATOR => 'Curator',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}