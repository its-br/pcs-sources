<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventPlanningStatus extends Model
{
    use HasFactory;

    use SoftDeletes;

    /**
     * Get the voyage that owns the event planning status.
     */
    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }
}
