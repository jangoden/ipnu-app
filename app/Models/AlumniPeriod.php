<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AlumniPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'period_year',
        'description',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }
}
