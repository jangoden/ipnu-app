<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlumniPeriodResource\Pages;
use App\Filament\Resources\AlumniPeriodResource\RelationManagers;
use App\Models\AlumniPeriod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Columns\TextColumn;

class AlumniPeriodResource extends Resource
{
    protected static ?string $model = AlumniPeriod::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $modelLabel = 'Data Alumni';

    protected static ?string $pluralModelLabel = 'Data Alumni';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('period_year')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable(),
                TextColumn::make('period_year')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\MembersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAlumniPeriods::route('/'),
            'create' => Pages\CreateAlumniPeriod::route('/create'),
            'view' => Pages\ViewAlumniPeriod::route('/{record}'),
            'edit' => Pages\EditAlumniPeriod::route('/{record}/edit'),
        ];
    }
}
