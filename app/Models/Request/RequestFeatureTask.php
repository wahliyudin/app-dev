<?php

namespace App\Models\Request;

use App\Enums\Request\Task\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestFeatureTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_feature_id',
        'due_date',
        'status',
        'content',
    ];

    protected $casts = [
        'status' => Status::class,
    ];

    public function feature()
    {
        return $this->belongsTo(RequestFeature::class, 'request_feature_id', 'id');
    }

    public function developers()
    {
        return $this->hasMany(RequestTaskDeveloper::class, 'request_feature_task_id', 'id');
    }
}
