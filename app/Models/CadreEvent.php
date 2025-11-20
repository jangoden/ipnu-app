<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CadreEvent extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'type',
        'start_date',
        'end_date',
        'location',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'type' => 'string',
        ];
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'cadre_event_participants')
            ->withPivot('status', 'certificate_number');
    }
}
