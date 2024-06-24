<?php

namespace App\Models\Request;

use App\Models\HCIS\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestDeveloper extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'nik',
    ];

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id', 'id');
    }

    public function developer()
    {
        return $this->belongsTo(Employee::class, 'nik', 'nik');
    }
}
