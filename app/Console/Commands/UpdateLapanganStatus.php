<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lapangan;
use Carbon\Carbon;

class UpdateLapanganStatus extends Command
{
    protected $signature = 'lapangan:update-status';
    protected $description = 'Nonaktifkan lapangan jika full booking hari ini';

    public function handle()
    {
        $today = Carbon::today();

        foreach (Lapangan::all() as $lapangan) {
            $isFull = $lapangan->isFullyBookedOnDate($today);
            $lapangan->status = !$isFull;
            $lapangan->save();
        }

        $this->info('Status lapangan telah diperbarui.');
    }
}
