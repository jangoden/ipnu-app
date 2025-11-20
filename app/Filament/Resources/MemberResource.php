<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Filament\Resources\MemberResource\RelationManagers;
use App\Models\Member;
use App\Models\Village;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Collection;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;
use App\Exports\MembersExport;
use App\Imports\MembersImport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getFormSchema(): array
    {
        return [
            Section::make('Personal Info')
                ->columns(2)
                ->schema([
                    TextInput::make('nik')->required()->maxLength(16)->unique(ignoreRecord: true),
                    TextInput::make('nia')->unique(ignoreRecord: true),
                    TextInput::make('full_name')->required(),
                    TextInput::make('username')->required()->unique(ignoreRecord: true),
                    TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
                    TextInput::make('phone_number')->tel()->required(),
                    TextInput::make('birth_place')->required(),
                    DatePicker::make('birth_date')->required(),
                    TextInput::make('hobby'),
                    Select::make('status')->options(['active' => 'Active', 'inactive' => 'Inactive', 'banned' => 'Banned'])->required(),
                    Select::make('grade')->options(['anggota' => 'Anggota', 'kader_makesta' => 'Kader Makesta', 'kader_lakmud' => 'Kader Lakmud', 'kader_lakut' => 'Kader Lakut'])->required(),
                    TextInput::make('password')
                        ->password()
                        ->required(fn (string $context): bool => $context === 'create')
                        ->dehydrated(fn ($state) => filled($state))
                        ->visibleOn('create'),
                ]),

            Section::make('Address')
                ->columns(2)
                ->schema([
                    TextInput::make('province')->default('Jawa Barat')->required(),
                    TextInput::make('city')->default('Kabupaten Ciamis')->required(),
                    Select::make('district_id')
                        ->relationship('district', 'name')
                        ->searchable()
                        ->live()
                        ->afterStateUpdated(function (Set $set) {
                            $set('village_id', null);
                        })
                        ->required(),
                    Select::make('village_id')
                        ->options(fn (Get $get): Collection => Village::query()->where('district_id', $get('district_id'))->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                    Textarea::make('address')->required()->columnSpanFull(),
                ]),

            Section::make('Alumni Info')
                ->collapsible()
                ->schema([
                    Select::make('alumni_period_id')
                        ->relationship('alumniPeriod', 'title')
                        ->searchable(),
                ]),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->schema(self::getFormSchema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nik')->label('NIK')->searchable(),
                TextColumn::make('full_name')->searchable(),
                TextColumn::make('grade')->searchable(),
                TextColumn::make('district.name')->searchable(),
                TextColumn::make('email')->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('phone_number')->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('grade')
                    ->options([
                        'anggota' => 'Anggota',
                        'kader_makesta' => 'Kader Makesta',
                        'kader_lakmud' => 'Kader Lakmud',
                        'kader_lakut' => 'Kader Lakut',
                    ]),
                SelectFilter::make('district')->relationship('district', 'name'),
            ])
            ->actions([
                EditAction::make(),
                ViewAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Action::make('import')
                    ->label('Import Members')
                    ->color('primary')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->form([
                        FileUpload::make('attachment')
                            ->required()
                            ->label('Excel File')
                    ])
                    ->action(function (array $data) {
                        Excel::import(new MembersImport, $data['attachment']);
                    }),
                Action::make('export')
                    ->label('Export Members')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (Table $table) {
                        $records = $table->getFilteredTableQuery()->get();
                        return Excel::download(new MembersExport($records), 'members.xlsx');
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}
