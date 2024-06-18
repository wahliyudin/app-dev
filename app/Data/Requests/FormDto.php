<?php

namespace App\Data\Requests;

use App\Models\Request\Request;

class FormDto
{
    public function __construct(
        public readonly ?string $nama_pemohon = null,
        public readonly ?string $job_title = null,
        public readonly ?string $department = null,
        public readonly ?string $department_id = null,
        public readonly ?string $application_name = null,
        public readonly ?string $pic_user = null,
        public readonly ?string $estimated_project = null,
        public readonly ?string $email = null,
        public readonly ?string $date = null,
    ) {
    }

    public static function fromModel(Request $request): self
    {
        return new self(
            $request->requestor->nama_karyawan,
            $request->job_title,
            $request->department,
            $request->requestor?->position?->dept_id,
            $request->application->display_name,
            $request->pic->nama_karyawan,
            $request->estimated_project ? carbon($request->estimated_project)->translatedFormat('d F Y') : '-',
            $request->email,
            $request->date ? carbon($request->date)->translatedFormat('d F Y') : '-',
        );
    }

    public static function fromDefault(): self
    {
        return new self(
            nama_pemohon: employeeByNIK()?->nama_karyawan,
            department: employeeByNIK()?->position?->department?->department_name,
            department_id: employeeByNIK()?->position?->dept_id,
        );
    }
}
