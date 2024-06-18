<?php

namespace App\Models\Request;

use App\Enums\Workflows\LastAction;
use App\Models\HCIS\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestWorkflow extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'sequence',
        'nik',
        'title',
        'last_action',
        'last_action_date',
    ];

    protected $casts = [
        'last_action' => LastAction::class
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik', 'nik');
    }
}
