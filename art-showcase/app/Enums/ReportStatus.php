<?php

namespace App\Enums;

enum ReportStatus: string
{
    case PENDING = 'pending';
    case REVIEWED = 'reviewed';
    case DISMISSED = 'dismissed';
    case TAKEN_DOWN = 'taken_down';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending Review',
            self::REVIEWED => 'Reviewed',
            self::DISMISSED => 'Dismissed',
            self::TAKEN_DOWN => 'Content Removed',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'yellow',
            self::REVIEWED => 'blue',
            self::DISMISSED => 'gray',
            self::TAKEN_DOWN => 'red',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}