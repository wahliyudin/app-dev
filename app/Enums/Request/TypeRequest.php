<?php

namespace App\Enums\Request;

enum TypeRequest: string
{
    case NEW_APPLICATION = 'new_application';
    case NEW_AUTOMATE_APPLICATION = 'new_automate_application';
    case ENHANCEMENT_TO_EXISTING_APPLICATION = 'enhancement_to_existing_application';
    case REPLACE_AN_EXISTING_APPLICATION = 'replace_an_existing_application';

    public function label(): string
    {
        return match ($this) {
            self::NEW_APPLICATION => 'New Application',
            self::NEW_AUTOMATE_APPLICATION => 'New Automate Application',
            self::ENHANCEMENT_TO_EXISTING_APPLICATION => 'Enhancement to Existing Application',
            self::REPLACE_AN_EXISTING_APPLICATION => 'Replace an Existing Application',
        };
    }
}
