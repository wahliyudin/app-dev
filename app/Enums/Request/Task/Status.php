<?php

namespace App\Enums\Request\Task;

enum Status: string
{
    case NOTTING = 'notting';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';

    public function label(): string
    {
        return match ($this) {
            self::NOTTING => 'Notting',
            self::IN_PROGRESS => 'In Progress',
            self::DONE => 'Done',
        };
    }

    public function id()
    {
        return match ($this) {
            self::NOTTING => '_' . self::NOTTING->value,
            self::IN_PROGRESS => '_' . self::IN_PROGRESS->value,
            self::DONE => '_' . self::DONE->value,
        };
    }

    public static function resetId($val): self
    {
        return match ($val) {
            '_' . self::NOTTING->value => self::NOTTING,
            '_' . self::IN_PROGRESS->value => self::IN_PROGRESS,
            '_' . self::DONE->value => self::DONE,
        };
    }

    public function isNotting()
    {
        return $this == self::NOTTING;
    }

    public function isInProgress()
    {
        return $this == self::IN_PROGRESS;
    }

    public function isDone()
    {
        return $this == self::DONE;
    }
}
