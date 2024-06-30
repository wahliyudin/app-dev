<?php

namespace App\Domain\Services\Applications;

use App\Models\Request\RequestApplication;

class ApplicationService
{
    public function findOrFail($id)
    {
        return RequestApplication::query()
            ->findOrFail($id);
    }
}
