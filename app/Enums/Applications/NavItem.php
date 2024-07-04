<?php

namespace App\Enums\Applications;

enum NavItem: string
{
    case OVERVIEW = 'overview';
    case TASK = 'task';
    case FEATURE = 'feature';
    case FILE = 'file';
    case DEVELOPER = 'developer';
    case SETTING = 'setting';

    public function label(): string
    {
        return match ($this) {
            self::OVERVIEW => 'Overview',
            self::TASK => 'Tasks',
            self::FEATURE => 'Features',
            self::FILE => 'Files',
            self::DEVELOPER => 'Developers',
            self::SETTING => 'Settings',
        };
    }

    public function url($id = 1)
    {
        return match ($this) {
            self::OVERVIEW => route('applications.view-app.index', $id),
            self::TASK => route('applications.tasks.index', $id),
            self::FEATURE => route('applications.features.index', $id),
            self::FILE => route('applications.files.index', $id),
            self::DEVELOPER => route('applications.developers.index', $id),
            self::SETTING => route('applications.settings.index', $id),
        };
    }
}
