<?php

namespace App\Enums\Request\Application;

enum Status: string
{
    case YET_TO_START = 'yet_to_start';
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::YET_TO_START => 'Yet to Start',
            self::IN_PROGRESS => 'In Progress',
            self::PENDING => 'Pending',
            self::COMPLETED => 'Completed',
        };
    }

    public function badge()
    {
        return match ($this) {
            self::YET_TO_START => '<span class="badge badge-light fw-bold px-4 py-3">' . self::YET_TO_START->label() . '</span>',
            self::IN_PROGRESS => '<span class="badge badge-light-primary fw-bold px-4 py-3">' . self::IN_PROGRESS->label() . '</span>',
            self::PENDING => '<span class="badge badge-light-warning fw-bold px-4 py-3">' . self::PENDING->label() . '</span>',
            self::COMPLETED => '<span class="badge badge-light-success fw-bold px-4 py-3">' . self::COMPLETED->label() . '</span>',
        };
    }
}
