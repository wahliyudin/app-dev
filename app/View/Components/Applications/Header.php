<?php

namespace App\View\Components\Applications;

use App\Enums\Applications\NavItem;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public NavItem $navItemActive,
        public $application,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.applications.header');
    }
}
