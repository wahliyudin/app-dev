<?php

namespace App\Domain\Services\HCIS;

use App\Models\HCIS\Employee;
use Illuminate\Support\Facades\DB;

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

    public function getDataForSelect($term, $withNik = true)
    {
        $selectText = $withNik ? DB::raw("CONCAT(nik, ' - ', nama_karyawan) AS text") : 'nama_karyawan AS text';
        return Employee::select([
            'nik AS id',
            'email_perusahaan',
            $selectText,
        ])
            ->when($term, function ($query, $term) {
                $term = mb_strtolower($term);
                $query->whereRaw('LOWER(nama_karyawan) like ?', ["%{$term}%"])
                    ->orWhere('nik', 'like', '%' . $term . '%');
            })
            ->limit(10)
            ->get();
    }
}
