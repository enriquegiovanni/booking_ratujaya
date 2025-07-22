<?php

namespace App\Filament\Resources\LapanganResource\Pages;

use App\Filament\Resources\LapanganResource;
use Filament\Resources\Pages\ListRecords;

class ListLapangans extends ListRecords
{
    protected static string $resource = LapanganResource::class;

    // Hilangkan tombol "Buat Lapangan"
    protected function getHeaderActions(): array
    {
        return [];
    }
}
