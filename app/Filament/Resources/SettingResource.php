<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Pengaturan';
    protected static ?string $modelLabel = 'Pengaturan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('key')
                    ->label('Kunci')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->disabled(fn($record) => $record && in_array($record->key, ['jam_buka', 'jam_tutup'])),

                TextInput::make('value')
                    ->label('Nilai')
                    ->required()
                    ->hidden(fn($record) => $record && in_array($record->key, ['jam_buka', 'jam_tutup'])),

                TimePicker::make('value')
                    ->label('waktu')
                    ->required()
                    ->seconds(false)
                    ->visible(fn($record) => $record && in_array($record->key, ['jam_buka', 'jam_tutup'])),

                Textarea::make('description')
                    ->label('Deskripsi')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Kunci')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'jam_buka' => 'Jam Buka',
                        'jam_tutup' => 'Jam Tutup',
                        default => $state
                    }),

                TextColumn::make('value')
                    ->label('Jam')
                    ->searchable()
                    ->formatStateUsing(function (string $state, $record): string {
                        if (in_array($record->key, ['jam_buka', 'jam_tutup'])) {
                            return date('H:i', strtotime($state));
                        }
                        return $state;
                    }),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
