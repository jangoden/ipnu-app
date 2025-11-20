<?php

namespace App\Filament\Resources\CadreEventResource\Pages;

use App\Filament\Resources\CadreEventResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCadreEvents extends ListRecords
{
    protected static string $resource = CadreEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
