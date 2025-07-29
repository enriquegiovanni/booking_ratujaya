<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Booking;
use Illuminate\Support\Carbon;

class TotalPendapatan extends BaseWidget
{
    protected function getStats(): array
    {
        $totalHariIni = Booking::with('lapangan')
            ->whereDate('tanggal', Carbon::today())
            ->get()
            ->sum(function ($booking) {
                // Hitung durasi dalam jam
                $durasi = \Carbon\Carbon::parse($booking->jam_mulai)->floatDiffInHours(\Carbon\Carbon::parse($booking->jam_selesai));
                $hargaPerJam = $booking->lapangan->harga_per_jam ?? 0;
                return $durasi * $hargaPerJam;
            });

        return [
            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalHariIni, 0, ',', '.'))
                ->description('Dari semua booking yang dijadwalkan hari ini')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}
