<?php

namespace KevinBHarris\Support\Events;

use KevinBHarris\Support\Models\Note;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NoteAdded
{
    use Dispatchable, SerializesModels;

    public Note $note;

    /**
     * Create a new event instance.
     */
    public function __construct(Note $note)
    {
        $this->note = $note;
    }
}
