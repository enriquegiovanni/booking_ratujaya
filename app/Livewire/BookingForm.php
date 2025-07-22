<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Lapangan;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class BookingForm extends Component
{
    public $lapangan;
    public $selectedDate;
    public $selectedTimeSlot;
    public $nama_pemesan;
    public $nomor_telepon;

    public $availableDates = [];
    public $availableTimeSlots = [];
    public $bookedSlots = [];
    public $operationalHours = [];
    public $totalPrice = 0;

    public function mount($lapanganId)
    {
        $this->lapangan = Lapangan::findOrFail($lapanganId);
        $this->loadOperationalHours();
        $this->generateAvailableDates();
    }

    public function loadOperationalHours()
    {
        $jamBuka = Setting::where('key', 'jam_buka')->first();
        $jamTutup = Setting::where('key', 'jam_tutup')->first();

        $this->operationalHours = [
            'jam_buka' => $jamBuka ? $jamBuka->value : '06:00',
            'jam_tutup' => $jamTutup ? $jamTutup->value : '23:00',
        ];
    }

    public function generateAvailableDates()
    {
        $dates = [];
        $today = Carbon::now();

        for ($i = 0; $i < 7; $i++) {
            $date = $today->copy()->addDays($i);
            $dates[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $this->getDayName($date->dayOfWeek),
                'formatted' => $date->format('d M'),
                'full_date' => $date
            ];
        }

        $this->availableDates = $dates;
    }

    public function getDayName($dayOfWeek)
    {
        $days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        return $days[$dayOfWeek];
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
        $this->selectedTimeSlot = null;
        $this->updateAvailableTimeSlots();
    }

    public function selectTimeSlot($timeSlot)
    {
        $this->selectedTimeSlot = $timeSlot;
        $this->calculatePrice();
    }

    public function updateAvailableTimeSlots()
    {
        if (!$this->selectedDate) return;

        $this->bookedSlots = Booking::where('lapangan_id', $this->lapangan->id)
            ->where('tanggal', $this->selectedDate)
            ->where('status', '!=', 'cancelled')
            ->get()
            ->map(function ($booking) {
                return [
                    'jam_mulai' => Carbon::parse($booking->jam_mulai)->format('H:i'),
                    'jam_selesai' => Carbon::parse($booking->jam_selesai)->format('H:i'),
                ];
            })->toArray();

        $this->generateTimeSlots();
    }

    public function generateTimeSlots()
    {
        $jamBuka = Carbon::parse($this->operationalHours['jam_buka']);
        $jamTutup = Carbon::parse($this->operationalHours['jam_tutup']);
        $slots = [];

        while ($jamBuka->lt($jamTutup)) {
            $jamMulai = $jamBuka->format('H:i');
            $jamSelesai = $jamBuka->copy()->addHour()->format('H:i');

            $isBooked = $this->isSlotBooked($jamMulai, $jamSelesai);

            $slots[] = [
                'jam_mulai' => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'label' => $jamMulai . ' - ' . $jamSelesai,
                'price' => $this->lapangan->price,
                'is_booked' => $isBooked,
                'slot_key' => $jamMulai . '-' . $jamSelesai,
            ];

            $jamBuka->addHour();
        }

        $this->availableTimeSlots = $slots;
    }

    public function isSlotBooked($jamMulai, $jamSelesai)
    {
        foreach ($this->bookedSlots as $booked) {
            $bookingStart = Carbon::parse($booked['jam_mulai']);
            $bookingEnd = Carbon::parse($booked['jam_selesai']);
            $slotStart = Carbon::parse($jamMulai);
            $slotEnd = Carbon::parse($jamSelesai);

            if ($slotStart->lt($bookingEnd) && $slotEnd->gt($bookingStart)) {
                return true;
            }
        }

        return false;
    }

    public function calculatePrice()
    {
        if ($this->selectedTimeSlot && $this->lapangan->price) {
            $this->totalPrice = $this->lapangan->price;
        }
    }

    public function submitBooking()
{
    $this->validate([
        'nama_pemesan' => 'required|string|max:255',
        'nomor_telepon' => 'required|string|max:20',
    ]);

    if (!$this->selectedDate || !$this->selectedTimeSlot) {
        $this->js("
            window.dispatchEvent(new CustomEvent('swal:error', {
                detail: { message: 'Silakan pilih tanggal dan jam terlebih dahulu.' }
            }))
        ");
        return;
    }

    $timeSlot = collect($this->availableTimeSlots)
        ->firstWhere('slot_key', $this->selectedTimeSlot);

    if (!$timeSlot || $timeSlot['is_booked']) {
        $this->js("
            window.dispatchEvent(new CustomEvent('swal:error', {
                detail: { message: 'Maaf, slot waktu yang dipilih sudah tidak tersedia.' }
            }))
        ");
        $this->updateAvailableTimeSlots();
        return;
    }

    try {
        DB::beginTransaction();

        $booking = Booking::create([
            'lapangan_id' => $this->lapangan->id,
            'tanggal' => $this->selectedDate,
            'jam_mulai' => $this->selectedDate . ' ' . $timeSlot['jam_mulai'],
            'jam_selesai' => $this->selectedDate . ' ' . $timeSlot['jam_selesai'],
            'nama_pemesan' => $this->nama_pemesan,
            'nomor_telepon' => $this->nomor_telepon,
            'status' => 'pending'
        ]);

        DB::commit();

        // Kirim invoice via WhatsApp
        $this->sendWhatsAppInvoice($booking, $timeSlot);

        $this->js("
            window.dispatchEvent(new CustomEvent('swal:success', {
                detail: { message: 'Booking berhasil dibuat! Silakan tunggu konfirmasi.' }
            }))
        ");

        $this->reset(['nama_pemesan', 'nomor_telepon', 'selectedTimeSlot']);
        $this->nomor_telepon = '62';
        $this->updateAvailableTimeSlots();
    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Booking Error: ' . $e->getMessage());

        $this->js("
            window.dispatchEvent(new CustomEvent('swal:error', {
                detail: { message: 'Terjadi kesalahan saat membuat booking.' }
            }))
        ");
    }
}

    protected function sendWhatsAppInvoice($booking, $timeSlot)
{
    $curl = curl_init();

    // Normalisasi nomor telepon (awalan 0 -> 62)
    $phone = preg_replace('/[^0-9]/', '', $this->nomor_telepon);
    if (substr($phone, 0, 1) === '0') {
        $phone = '62' . substr($phone, 1);
    } elseif (!str_starts_with($phone, '62')) {
        $phone = '62' . $phone;
    }

    // Harga (fallback Rp 40.000 jika tidak ada)
    $harga = $timeSlot['price'] ?? 40000;
    $formattedPrice = 'Rp ' . number_format($harga, 0, ',', '.');

    // Kode unik booking
    $kodeBooking = 'BK-' . now()->format('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

    // Format invoice
    $message = "*INVOICE BOOKING GOR RATU JAYA RATUJAYA*\n";
    $message .= "==============================\n";
    $message .= "📌 *Kode Booking* : *{$kodeBooking}*\n";
    $message .= "👤 *Nama*         : {$this->nama_pemesan}\n";
    $message .= "🏸 *Lapangan*     : {$this->lapangan->title}\n";
    $message .= "📅 *Tanggal*      : " . date('d F Y', strtotime($booking->tanggal)) . "\n";
    $message .= "⏰ *Jam*          : {$timeSlot['jam_mulai']} - {$timeSlot['jam_selesai']}\n";
    $message .= "💰 *Harga*        : {$formattedPrice}\n";
    $message .= "==============================\n";
    $message .= "📍 *Lokasi*: GOR Ratu Jaya, Depok\n";
    $message .= "Silakan datang 10 menit sebelum waktu main.\n\n";
    $message .= "❗ Simpan pesan ini sebagai bukti booking.\n";
    $message .= "_Terima kasih telah booking di GOR Ratu Jaya!_ 🙏";

    // Ambil token dari .env
    $token = env('FONNTE_API_TOKEN');
    if (!$token) {
        Log::warning('FONNTE_API_TOKEN not set');
        return;
    }

    // Kirim ke Fonnte
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => [
            'target' => $phone,
            'message' => $message,
            'countryCode' => '62',
        ],
        CURLOPT_HTTPHEADER => [
            'Authorization: ' . $token,
        ],
    ]);

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        Log::error('WhatsApp API Error: ' . curl_error($curl));
    } else {
        Log::info("Invoice sent to $phone | Fonnte: $response");
    }

    curl_close($curl);
}

    public function render()
    {
        return view('livewire.booking-form');
    }
}
