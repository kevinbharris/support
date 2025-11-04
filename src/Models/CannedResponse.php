<?php

namespace KevinBHarris\Support\Models;

use Illuminate\Database\Eloquent\Model;

class CannedResponse extends Model
{
    protected $table = 'support_canned_responses';

    protected $fillable = [
        'title',
        'shortcut',
        'content',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
