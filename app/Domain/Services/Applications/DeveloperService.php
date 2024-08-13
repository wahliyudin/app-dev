<?php

namespace App\Domain\Services\Applications;

use App\Models\Request\RequestDeveloper;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DeveloperService extends ApplicationService
{
    public function store($request)
    {
        return DB::transaction(function () use ($request) {
            return RequestDeveloper::query()->updateOrCreate([
                'nik' => $request->developer_nik,
                'request_id' => $request->request_id,
            ], [
                'request_id' => $request->request_id,
                'nik' => $request->developer_nik,
            ]);
        });
    }

    public function datatable($id)
    {
        return RequestDeveloper::query()
            ->with(['developer:nik,nama_karyawan'])
            ->where('request_id', $id)
            ->get();
    }

    public function getDeveloperByRequestId($requestId)
    {
        return RequestDeveloper::query()
            ->where('request_id', $requestId)
            ->get();
    }

    public function getDevelopers($request)
    {
        $search = $request->get('q');

        $developers = User::query()
            ->whereHas('roles', function ($query) {
                $query->where('name', 'developer');
            })
            ->with(['employee' => function ($query) use ($search) {
                $query->select(['nik', 'nama_karyawan'])
                    ->with('identity:nik,avatar')
                    ->when($search, function ($query) use ($search) {
                        $query->where('nik', 'like', '%' . $search . '%')
                            ->orWhere('nama_karyawan', 'like', '%' . $search . '%');
                    });
            }])
            ->get();

        $formattedDevelopers = [];
        foreach ($developers as $developer) {
            if ($developer->employee) {
                $formattedDevelopers[] = [
                    'id' => $developer->nik,
                    'text' => $developer->employee?->nama_karyawan,
                    'subcontent' => $developer->nik,
                    'icon' => config('urls.hcis') . 'storage/' . $developer->employee?->identity?->avatar,
                ];
            }
        }
        return $formattedDevelopers;
    }

    public function findOrFailDeveloper($key)
    {
        return RequestDeveloper::query()->findOrFail($key);
    }

    public function destroy($key)
    {
        return DB::transaction(function () use ($key) {
            RequestDeveloper::query()->findOrFail($key)->delete();
        });
    }

    public function getAllDevelopers()
    {
        return User::query()
            ->whereHas('roles', function ($query) {
                $query->where('name', 'developer');
            })
            ->with(['employee' => function ($query) {
                $query->select(['nik', 'nama_karyawan'])
                    ->with('identity:nik,avatar');
            }])
            ->get();
    }
}
