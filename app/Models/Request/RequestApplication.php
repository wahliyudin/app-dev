<?php

namespace App\Models\Request;

use App\Enums\Request\Application\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'name',
        'display_name',
        'logo',
        'due_date',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => Status::class,
    ];

    public function logo(): string
    {
        return $this->logo ? asset('storage/' . $this->logo) : asset('assets/media/logos/tbu-crop.png');
    }
}
