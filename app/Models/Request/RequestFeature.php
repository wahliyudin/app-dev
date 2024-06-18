<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];
}
