<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'name',
        'description',
    ];

    public function tasks()
    {
        return $this->hasMany(RequestFeatureTask::class, 'request_feature_id', 'id');
    }

    public function application()
    {
        return $this->belongsTo(RequestApplication::class, 'application_id', 'id');
    }
}
