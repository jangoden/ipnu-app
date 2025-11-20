<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BranchExecutive extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'member_id',
        'position',
        'period_start',
        'period_end',
        'is_active',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
