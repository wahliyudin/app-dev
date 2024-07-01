<?php

namespace App\Domain\Services\Applications;

use App\Models\Request\RequestApplication;

class ApplicationService
{
    public function findOrFail($id)
    {
        return RequestApplication::query()
            ->with(['request' => function ($query) {
                $query->select(['id', 'code', 'application_id'])
                    ->with('features');
            }])
            ->findOrFail($id);
    }
}
