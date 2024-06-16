<?php

namespace App\Domain\Services\HCIS;

use App\Models\HCIS\Employee;

class EmployeeService
{
    public function all(array $attributes)
    {
        return Employee::select($attributes)->get();
    }

    public function findByNik($nik)
    {
        return Employee::query()
            ->with([
                'position' => function ($query) {
                    $query->with([
                        'divisi',
                        'project',
                        'department',
                    ]);
                }
            ])
            ->where('nik', $nik)
            ->first();
    }
}
