<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'nik',
        'nia',
        'username',
        'email',
        'password',
        'full_name',
        'birth_place',
        'birth_date',
        'address',
        'province',
        'city',
        'district_id',
        'village_id',
        'phone_number',
        'hobby',
        'status',
        'grade',
        'alumni_period_id',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'status' => 'string',
            'grade' => 'string',
            'password' => 'hashed',
        ];
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function alumniPeriod(): BelongsTo
    {
        return $this->belongsTo(AlumniPeriod::class);
    }

    public function cadreEvents(): BelongsToMany
    {
        return $this->belongsToMany(CadreEvent::class, 'cadre_event_participants')
            ->withPivot('status', 'certificate_number');
    }
}
