<?php

namespace App\Domain\Services\Applications;

use App\Enums\Request\Task\Status;
use App\Models\Request\RequestApplication;

class ApplicationService
{
    public function findOrFail($id)
    {
        return RequestApplication::query()
            ->with(['request' => function ($query) {
                $query->select(['id', 'code', 'application_id'])
                    ->with(['features' => function ($query) {
                        $query->withCount(['tasks as total_open' => function ($query) {
                            $query->where('status', Status::NOTTING);
                        }, 'tasks as total_progress' => function ($query) {
                            $query->where('status', Status::IN_PROGRESS);
                        }, 'tasks as total_done' => function ($query) {
                            $query->where('status', Status::DONE);
                        }]);
                    }, 'developers' => function ($query) {
                        $query->with(['developer' => function ($query) {
                            $query->select('nik', 'nama_karyawan')
                                ->with('identity:nik,avatar');
                        }]);
                    }]);
            }])
            ->findOrFail($id);
    }
}
