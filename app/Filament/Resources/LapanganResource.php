<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LapanganResource\Pages;
use App\Filament\Resources\LapanganResource\RelationManagers;
use App\Models\Lapangan;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Nette\Utils\ImageColor;

class LapanganResource extends Resource
{
    protected static ?string $model = Lapangan::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $slug = 'lapangan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Nama Lapangan')
                    ->required()
                    ->columnSpanFull(),

                Select::make('category')
                    ->label('Kategori')
                    ->options([
                        'Lapangan 1' => 'Lapangan 1',
                        'Lapangan 2' => 'Lapangan 2',
                        'Lapangan 3' => 'Lapangan 3',
                        'Lapangan 4' => 'Lapangan 4',
                        'Lapangan 5' => 'Lapangan 5',
                        'Lapangan 6' => 'Lapangan 6',
                        'Lapangan 7' => 'Lapangan 7',
                    ])
                    ->required(),

                TextInput::make('price')
                    ->label('Harga per jam')
                    ->numeric()
                    ->prefix('Rp.')
                    ->step(100)
                    ->required(),

                RichEditor::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->columnSpanFull(),

                FileUpload::make('images')
                    ->label('Gambar Lapangan')
                    ->image()
                    ->multiple()
                    ->maxFiles(3)
                    ->required()
                    ->directory('lapangan-images')
                    ->columnSpanFull()
                    ->helperText('Maksimal 3 gambar'),

                Toggle::make('status')
                    ->default(true)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Nama Lapangan')
                    ->searchable(),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge(),
                TextColumn::make('price')
                    ->label('Harga per jam')
                    ->sortable()
                    ->money('IDR'),
                ImageColumn::make('images')
                    ->label('Gambar Lapangan')
                    ->circular()
                    ->stacked()
                    ->limit(3),
                IconColumn::make('status')
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
            'index' => Pages\ListLapangans::route('/'),
            'create' => Pages\CreateLapangan::route('/create'),
            'edit' => Pages\EditLapangan::route('/{record}/edit'),
        ];
    }
}
