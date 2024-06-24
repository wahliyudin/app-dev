<?php

namespace App\Domain\Sidebars\Modules\Approval;

use App\Domain\Services\Request\RequestService;
use App\Domain\Sidebars\Contracts\SidebarInterface;

class Request implements SidebarInterface
{
    public function total(): int
    {
        /** @var RequestService $service */
        $service = app(RequestService::class);
        return $service->totalCurrentApproval();
    }
}
