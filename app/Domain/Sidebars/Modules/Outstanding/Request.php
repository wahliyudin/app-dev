<?php

namespace App\Domain\Sidebars\Modules\Outstanding;

use App\Domain\Sidebars\Contracts\SidebarInterface;

class Request implements SidebarInterface
{
    public function total(): int
    {
        return 0;
    }
}
