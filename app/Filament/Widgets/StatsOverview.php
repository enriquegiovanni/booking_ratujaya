<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Lapangan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Hitung total booking
        $totalBooking = Booking::count();

        // Hitung booking hari ini
        $bookingHariIni = Booking::whereDate('tanggal', Carbon::today())->count();

        // Hitung jumlah lapangan tersedia (status = true)
        $lapanganTersedia = Lapangan::where('status', true)->count();

        return [
            Stat::make('Total Booking', $totalBooking)
                ->description('Semua booking tercatat')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),

            Stat::make('Booking Hari Ini', $bookingHariIni)
                ->description('Booking yang dijadwalkan hari ini')
                ->descriptionIcon('heroicon-m-clock')
                ->color('success'),

            Stat::make('Lapangan Tersedia', $lapanganTersedia)
                ->description('Lapangan yang aktif & dapat dipesan')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('warning'),
        ];
    }
}
