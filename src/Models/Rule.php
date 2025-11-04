<?php

namespace KevinBHarris\Support\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $table = 'support_rules';

    protected $fillable = [
        'name',
        'description',
        'conditions',
        'actions',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'conditions' => 'array',
        'actions' => 'array',
        'is_active' => 'boolean',
    ];
}
