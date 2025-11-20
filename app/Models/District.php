<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function villages(): HasMany
    {
        return $this->hasMany(Village::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function pacExecutives(): HasMany
    {
        return $this->hasMany(PacExecutive::class);
    }
}
