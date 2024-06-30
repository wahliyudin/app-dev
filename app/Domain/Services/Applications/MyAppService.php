<?php

namespace App\Domain\Services\Applications;

use App\Models\Request\RequestApplication;

class MyAppService
{
    public function getApps($status = null)
    {
        return RequestApplication::query()
            ->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->paginate(3);
    }
}
