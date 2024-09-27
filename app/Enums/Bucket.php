<?php

namespace App\Enums;

enum Bucket
{
    case CATEGORY;
    case TICKET;
    case TEAM;

    public function toString(): string
    {
        return match ($this) {
            self::CATEGORY    => 'categories',
            self::TICKET   => 'tickets',
            self::TEAM    => 'teams',
        };
    }
}
