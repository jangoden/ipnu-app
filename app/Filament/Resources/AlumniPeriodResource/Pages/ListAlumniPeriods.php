<?php

namespace App\Filament\Resources\AlumniPeriodResource\Pages;

use App\Filament\Resources\AlumniPeriodResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAlumniPeriods extends ListRecords
{
    protected static string $resource = AlumniPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
