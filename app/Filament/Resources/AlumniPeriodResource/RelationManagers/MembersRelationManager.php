<?php

namespace App\Filament\Resources\AlumniPeriodResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;

use Filament\Tables\Actions\Action;
use App\Exports\AlumniMembersExport;
use Maatwebsite\Excel\Facades\Excel;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    protected static ?string $title = 'Anggota Alumni';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')
            ->columns([
                TextColumn::make('full_name')->searchable(),
                TextColumn::make('address')->searchable(),
                TextColumn::make('hobby')->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('export')
                    ->label('Export Alumni')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (Table $table) {
                        $records = $table->getFilteredTableQuery()->get();
                        return Excel::download(new AlumniMembersExport($records), 'alumni.xlsx');
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->url(fn ($record) => url('/admin/members/'.$record->id)),
            ])
            ->bulkActions([
                // No bulk actions needed here
            ]);
    }
}
