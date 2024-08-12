<?php

namespace App\Domain\Gateway\Dto;

use Spatie\LaravelData\Data;

class EmployeeDto extends Data
{
    public function __construct(
        public readonly ?string $nik = null,
        public readonly ?string $nama_karyawan = null,
        public readonly ?string $position_id = null,
        public readonly ?string $grade_id = null,
        public readonly ?string $costing = null,
        public readonly ?string $activity = null,
        public readonly ?string $tipe_kontrak = null,
        public readonly ?string $tgl_bergabung = null,
        public readonly ?string $tgl_pengangkatan = null,
        public readonly ?string $resign_date = null,
        public readonly ?string $tgl_naik_level = null,
        public readonly ?string $tgl_mcu_terakhir = null,
        public readonly ?string $email_perusahaan = null,
        public readonly ?string $point_of_hire = null,
        public readonly ?string $point_of_leave = null,
        public readonly ?string $ring_clasification = null,
        public readonly ?string $tipe_mess = null,
        public readonly ?string $martial_status_id = null,
        public readonly ?string $status = null,
        public readonly ?PositionDto $position = null,
    ) {}
}
