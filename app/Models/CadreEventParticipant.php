<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CadreEventParticipant extends Pivot
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'cadre_event_id',
        'member_id',
        'status',
        'certificate_number',
    ];

    public function cadreEvent(): BelongsTo
    {
        return $this->belongsTo(CadreEvent::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
