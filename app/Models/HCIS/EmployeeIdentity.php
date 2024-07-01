<?php

namespace App\Models\HCIS;

use App\Data\Applications\TaskDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeIdentity extends Model
{
    use HasFactory;

    protected $table = 'employee_personal_identities';

    protected $primaryKey = 'employee_id';

    protected $fillable = [
        'employee_id',
        'nik',
        'jenis_kelamin',
        'tempat_lahir',
        'tgl_lahir',
        'alamat_ktp',
        'alamat_domisili',
        'agama',
        'golongan_darah',
        'no_hp',
        'email',
        'no_ktp',
        'no_kk',
        'no_npwp',
        'no_bpjs_tk',
        'no_bpjs_kesehatan',
        'ukuran_baju',
        'ukuran_celana',
        'ukuran_sepatu',
        'ukuran_helmet',
        'avatar',

        'nomor_paspor',
        'masa_berlaku_paspor',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik', 'nik');
    }
}
