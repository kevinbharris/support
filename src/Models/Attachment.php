<?php

namespace KevinBHarris\Support\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Attachment extends Model
{
    protected $table = 'support_attachments';

    protected $fillable = [
        'attachable_type',
        'attachable_id',
        'name',
        'filename',
        'mime_type',
        'size',
        'path',
    ];

    /**
     * Get the owning attachable model.
     */
    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }
}
