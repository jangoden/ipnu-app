<?php

namespace App\Filament\Resources\CadreEventResource\Pages;

use App\Filament\Resources\CadreEventResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListCadreEvents extends ListRecords
{
    protected static string $resource = CadreEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'makesta' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'makesta')),
            'lakmud' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'lakmud')),
            'lakut' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'lakut')),
        ];
    }
}
