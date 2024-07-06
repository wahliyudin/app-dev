<?php

namespace App\Models\Request;

use App\Domain\Workflows\Contracts\ModelThatHaveWorkflow;
use App\Enums\Request\TypeBudget;
use App\Enums\Request\TypeRequest;
use App\Enums\Workflows\LastAction;
use App\Enums\Workflows\Status;
use App\Models\HCIS\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Request extends Model implements ModelThatHaveWorkflow
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
        'feature_name',
        'feature_id',
    ];

    protected $casts = [
        'type_request' => TypeRequest::class,
        'type_budget' => TypeBudget::class,
        'status' => Status::class,
    ];

    public function workflow(): HasOne
    {
        return $this->hasOne(RequestWorkflow::class)->ofMany([
            'sequence' => 'min',
        ], function ($query) {
            $query->where('last_action', LastAction::NOTTING);
        });
    }

    public function workflows(): HasMany
    {
        return $this->hasMany(RequestWorkflow::class);
    }

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

    public function developers()
    {
        return $this->hasMany(RequestDeveloper::class, 'request_id', 'id');
    }

    public function feature()
    {
        return $this->belongsTo(RequestFeature::class, 'feature_id', 'id');
    }
}
