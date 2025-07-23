<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use App\Models\Lapangan;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Booking';
    protected static ?string $modelLabel = 'Booking';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('lapangan_id')
                    ->label('Nama Lapangan')
                    ->options(Lapangan::where('status', true)->pluck('title', 'id'))
                    ->required(),

                DatePicker::make('tanggal')
                    ->required()
                    ->native(false)
                    ->minDate(now()),

                TimePicker::make('jam_mulai')->required()->seconds(false),
                TimePicker::make('jam_selesai')->required()->seconds(false),

                TextInput::make('nama_pemesan')->required(),
                TextInput::make('nomor_telepon')->required(),

                // Hanya 1 opsi status: confirmed
                Select::make('status')
                    ->options([
                        'confirmed' => 'Dikonfirmasi',
                    ])
                    ->default('confirmed')
                    ->disabled()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lapangan.title')->label('Lapangan')->searchable()->sortable(),
                TextColumn::make('tanggal')->date()->sortable(),
                TextColumn::make('jam_mulai')->time('H:i'),
                TextColumn::make('jam_selesai')->time('H:i'),
                TextColumn::make('nama_pemesan')->searchable(),
                TextColumn::make('nomor_telepon')->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'completed' => 'info',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'confirmed' => 'Dikonfirmasi',
                        'cancelled' => 'Dibatalkan',
                        'completed' => 'Selesai',
                    }),
            ])
            ->filters([])
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            // 'create' => Pages\CreateBooking::route('/create'), // Dihapus agar tidak bisa buat booking
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
