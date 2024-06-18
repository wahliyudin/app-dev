<?php

namespace App\Models\Request;

use App\Enums\Request\TypeBudget;
use App\Enums\Request\TypeRequest;
use App\Enums\Workflows\Status;
use App\Models\HCIS\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'nik_requestor',
        'job_title',
        'department',
        'application_id',
        'nik_pic',
        'estimated_project',
        'email',
        'date',
        'type_request',
        'type_budget',
        'description',
        'status',
        'note',
    ];

    protected $casts = [
        'type_request' => TypeRequest::class,
        'type_budget' => TypeBudget::class,
        'status' => Status::class,
    ];

    public function requestor()
    {
        return $this->belongsTo(Employee::class, 'nik_requestor', 'nik');
    }

    public function application()
    {
        return $this->belongsTo(RequestApplication::class, 'application_id', 'id');
    }

    public function pic()
    {
        return $this->belongsTo(Employee::class, 'nik_pic', 'nik');
    }

    public function attachments()
    {
        return $this->hasMany(RequestAttachment::class, 'request_id', 'id');
    }

    public function features()
    {
        return $this->hasMany(RequestFeature::class, 'request_id', 'id');
    }
}
