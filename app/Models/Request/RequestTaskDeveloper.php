<?php

namespace App\Models\Request;

use App\Models\HCIS\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestTaskDeveloper extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_feature_task_id',
        'nik',
    ];

    public function task()
    {
        return $this->belongsTo(RequestFeatureTask::class, 'request_feature_task_id', 'id');
    }

    public function developer()
    {
        return $this->belongsTo(Employee::class, 'nik', 'nik');
    }
}
