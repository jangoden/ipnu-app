<?php

namespace App\Filament\Resources\AlumniPeriodResource\Pages;

use App\Filament\Resources\AlumniPeriodResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAlumniPeriod extends EditRecord
{
    protected static string $resource = AlumniPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
