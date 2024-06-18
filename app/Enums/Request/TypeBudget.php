<?php

namespace App\Enums\Request;

enum TypeBudget: string
{
    case BUDGET = 'budget';
    case UNBUDGET = 'unbudget';

    public function label(): string
    {
        return match ($this) {
            self::BUDGET => 'Budget',
            self::UNBUDGET => 'Unbudget',
        };
    }
}
