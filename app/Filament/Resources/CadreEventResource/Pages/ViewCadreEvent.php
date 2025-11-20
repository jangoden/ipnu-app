<?php

namespace App\Filament\Resources\CadreEventResource\Pages;

use App\Filament\Resources\CadreEventResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCadreEvent extends ViewRecord
{
    protected static string $resource = CadreEventResource::class;

    protected static ?string $title = 'Lihat Kaderisasi';
}
