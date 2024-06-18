<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'name',
        'path',
        'original_name',
    ];
}
