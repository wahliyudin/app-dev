<?php

namespace App\Domain\Services\Applications;

use App\Models\Request\RequestAttachment;

class FileService extends ApplicationService
{
    public function getAttachments($id)
    {
        return RequestAttachment::query()
            ->whereHas('request', function ($query) use ($id) {
                $query->whereHas('application', function ($query) use ($id) {
                    $query->where('id', $id);
                });
            })
            ->paginate(10);
    }
}
