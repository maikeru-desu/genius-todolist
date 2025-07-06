<?php

declare(strict_types=1);

namespace App\Enums;

enum TaskPriority: int
{
    case HIGH = 2;
    case MEDIUM = 1;
    case LOW = 0;

    /**
     * Get all values as an array
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get the color class associated with this priority
     */
    public function color(): string
    {
        return match ($this) {
            self::HIGH => 'bg-red-100 text-red-800',
            self::MEDIUM => 'bg-yellow-100 text-yellow-800',
            self::LOW => 'bg-green-100 text-green-800',
        };
    }

    /**
     * Get the name of this priority level
     */
    public function name(): string
    {
        return match ($this) {
            self::HIGH => 'high',
            self::MEDIUM => 'medium',
            self::LOW => 'low',
        };
    }

    /**
     * Get the badge text for this priority
     */
    public function label(): string
    {
        return match ($this) {
            self::HIGH => 'High Priority',
            self::MEDIUM => 'Medium Priority',
            self::LOW => 'Low Priority',
        };
    }

    /**
     * Get numeric value for sorting (higher number = higher priority)
     */
    public function sortOrder(): int
    {
        return match ($this) {
            self::HIGH => 2,
            self::MEDIUM => 1,
            self::LOW => 0,
        };
    }
}
