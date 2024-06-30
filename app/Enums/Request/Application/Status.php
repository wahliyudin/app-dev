<?php

namespace App\Enums\Request\Application;

enum Status: string
{
    case ACTIVE = 'active';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::IN_PROGRESS => 'In Progress',
            self::COMPLETED => 'Completed',
        };
    }

    public function badge()
    {
        return match ($this) {
            self::ACTIVE => '<span class="badge badge-light-primary fw-bold px-4 py-3">' . self::ACTIVE->label() . '</span>',
            self::IN_PROGRESS => '<span class="badge badge-light-warning fw-bold px-4 py-3">' . self::IN_PROGRESS->label() . '</span>',
            self::COMPLETED => '<span class="badge badge-light-success fw-bold px-4 py-3">' . self::COMPLETED->label() . '</span>',
        };
    }
}
