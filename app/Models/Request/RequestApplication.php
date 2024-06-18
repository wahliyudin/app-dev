<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'name',
        'display_name',
    ];
}
