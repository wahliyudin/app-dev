<?php

namespace App\Models\Request;

use App\Enums\SvgTypeFile\TypeFile;
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
        'display_name',
        'type_file',
    ];

    protected $casts = [
        'type_file' => TypeFile::class,
    ];

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id', 'id');
    }
}
