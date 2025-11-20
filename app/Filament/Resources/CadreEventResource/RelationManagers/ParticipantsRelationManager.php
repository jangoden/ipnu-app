<?php

namespace App\Filament\Resources\CadreEventResource\RelationManagers;

use App\Filament\Resources\MemberResource;
use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use App\Models\District;
use App\Models\Village;
use Illuminate\Support\Collection;
use Filament\Forms\Get;

class ParticipantsRelationManager extends RelationManager
{
    protected static string $relationship = 'participants';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')
            ->columns([
                Tables\Columns\TextColumn::make('full_name'),
                Tables\Columns\TextColumn::make('pivot.status')->label('Status'),
                Tables\Columns\TextColumn::make('pivot.certificate_number')->label('Certificate'),
            ])
            ->filters([
                //
            ])


            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->authorize(true)
                    ->form([
                        TextInput::make('nik')->required()->maxLength(16)->unique('members', 'nik'),
                        TextInput::make('full_name')->required(),
                        TextInput::make('username')->required()->unique('members', 'username'),
                        TextInput::make('email')->required()->email()->unique('members', 'email'),
                        TextInput::make('password')->required()->password()->confirmed(),
                        TextInput::make('password_confirmation')->required()->password(),
                        TextInput::make('birth_place')->required(),
                        DatePicker::make('birth_date')->required(),
                        Select::make('district_id')
                            ->options(District::all()->pluck('name', 'id')->toArray())
                            ->searchable()
                            ->live()
                            ->required(),
                        Select::make('village_id')
                            ->options(fn (Get $get): Collection => Village::query()->where('district_id', $get('district_id'))->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Textarea::make('address')->required(),
                        TextInput::make('phone_number')->tel()->required(),
                    ]),
                Tables\Actions\AttachAction::make()
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect()->multiple(),
                    ])
                    ->preloadRecordSelect()
                    ->authorize(true),
            ])
            ->actions([
                Action::make('Set Lulus')
                    ->action(function (Member $record) {
                        $record->pivot->update(['status' => 'graduated']);
                    })
                    ->requiresConfirmation()
                    ->color('success')
                    ->hidden(fn (Member $record) => $record->pivot->status === 'graduated'),
                Tables\Actions\EditAction::make()->form(function (Form $form, Member $record) {
                    return $form->schema([
                        Forms\Components\Select::make('status')->options(['registered' => 'Registered', 'graduated' => 'Graduated', 'failed' => 'Failed'])->required(),
                        Forms\Components\TextInput::make('certificate_number'),
                    ]);
                }),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}

