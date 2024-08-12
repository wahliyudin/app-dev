<?php

namespace App\Domain\Services\HCIS;

use App\Domain\Gateway\Dto\EmployeeDto;
use App\Domain\Gateway\Services\EmployeeService as ParentService;

class EmployeeService
{
    public function __construct(
        public ParentService $parentService
    ) {}

    public function all(array $attributes)
    {
        $employees = $this->parentService->select($attributes)->all();
        return EmployeeDto::collect($employees);
    }

    public function findByNik($nik)
    {
        $employee = $this->parentService->with(['position.divisi', 'position.project', 'position.department'])
            ->where('nik', $nik)
            ->first();
        return EmployeeDto::from($employee);
    }

    public function getDataForSelect($term, $withNik = true)
    {
        return $this->parentService->dataForSelect($term, $withNik);
    }
}
