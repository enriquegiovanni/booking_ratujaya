<div>
    {{-- 🔔 FLASH MESSAGE --}}
    @if (session()->has('success'))
        <div class="mb-5 p-4 bg-green-100 border border-green-300 text-green-800 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-5 p-4 bg-red-100 border border-red-300 text-red-800 rounded-xl">
            {{ session('error') }}
        </div>
    @endif

    {{-- 💡 DETAIL LAPANGAN --}}
    <div class="flex flex-col md:flex-row gap-3">
        <div class="w-full md:w-8/12">
            <span
                class="text-xs w-max py-2 px-6 rounded-full {{ $lapangan->category == 'lapangan1' ? 'bg-tertiary' : 'bg-primary' }} text-white font-semibold flex items-center gap-2">
                <i class="ai-star"></i>
                {{ $lapangan->category }}
            </span>
            <h4 class="text-4xl font-semibold mt-2">{{ $lapangan->title }}</h4>
            <hr class="border border-gray-200 my-10">
            <div class="mb-5">
                <p class="text-lg font-medium mb-2">Deskripsi</p>
                <div class="text-gray-700">
                    {!! $lapangan->description !!}
                </div>
            </div>
        </div>

        <div class="w-full md:w-6/12 lg:w-4/12">
    <div class="rounded-2xl bg-white p-10 shadow-lg">
        <p class="mb-2 text-gray-500 text-base">Mulai dari</p>
        <p class="font-bold text-3xl text-black">
            Rp. 40,000 <span class="text-sm font-normal text-gray-600">per sesi</span>
        </p>
    </div>
</div>

    </div>

    {{-- 📅 PILIH TANGGAL --}}
    <hr class="border border-gray-200 my-10">
    <p class="text-lg font-medium mb-5">Pilih Tanggal</p>
    <div class="grid grid-cols-3 md:grid-cols-8 gap-2 mb-5" id="booking-form">
        @foreach ($availableDates as $date)
            <button wire:click="selectDate('{{ $date['date'] }}')"
                class="cursor-pointer border rounded-xl text-center p-6 transition {{ $selectedDate === $date['date'] ? 'bg-primary border-primary text-white' : 'bg-white border border-gray-200 text-black hover:bg-primary hover:border-primary hover:text-white' }}">
                <p class="font-medium">{{ $date['day'] }}</p>
                <p class="font-semibold">{{ $date['formatted'] }}</p>
            </button>
        @endforeach
        <button
            class="cursor-pointer bg-white border border-gray-200 rounded-xl text-center text-black p-6 transition hover:bg-primary hover:border-primary hover:text-white">
            <i class="ai-calendar text-2xl"></i>
        </button>
    </div>

    {{-- ⏰ PILIH JAM --}}
@if ($selectedDate)
    <p class="text-lg font-medium mb-5">Pilih Jam</p>
    <div class="grid grid-cols-2 md:grid-cols-6 gap-2 mb-5">
    <div class="flex justify-end space-x-3 mb-4">
    <button 
        wire:click="selectAllTimeSlots"
        class="bg-primary text-white px-4 py-2 rounded hover:bg-primary/80 transition">
        Pilih Semua Jam
    </button>
</div>

        @foreach ($availableTimeSlots as $slot)
            @if ($slot['is_booked'])
                <button class="bg-white border border-gray-200 rounded-xl text-center text-gray-400 p-6 transition">
                    <p class="font-normal text-sm">60 Menit</p>
                    <p class="font-semibold">{{ $slot['label'] }}</p>
                    <p class="font-normal text-sm">Booked</p>
                </button>
            @else
                <button wire:click="selectTimeSlot('{{ $slot['slot_key'] }}')"
                    class="relative cursor-pointer bg-white border rounded-xl text-center text-black p-6
                        {{ in_array($slot['slot_key'], $selectedTimeSlots) ? 'border-primary' : 'border-gray-200 hover:border-primary' }}">
                    <p class="font-normal text-sm">60 Menit</p>
                    <p class="font-semibold">{{ $slot['label'] }}</p>
                    <p class="font-normal text-sm">Rp. {{ number_format($slot['price']) }}</p>

                    @if (in_array($slot['slot_key'], $selectedTimeSlots))
                        <span
                            class="size-7 rounded-full bg-primary text-white absolute top-1 right-1 flex items-center justify-center">
                            <i class="ai-check"></i>
                        </span>
                    @endif
                </button>
            @endif
        @endforeach
    </div>
@endif


    {{-- 🧍 ISI DATA DIRI --}}
    @if ($selectedDate && count($selectedTimeSlots) > 0)
        <p class="text-lg font-medium mb-5">Isi Data Diri</p>
        <form wire:submit.prevent="submitBooking">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-3">
                <div>
                    <label for="name" class="text-sm text-gray-700">Nama atau Tim</label>
                    <input type="text" wire:model="nama_pemesan"
                        class="block w-full py-2.5 px-4 rounded-xl border border-gray-300 focus:border-primary focus:shadow focus:drop-shadow-primary outline-none "
                        placeholder="Isi Nama atau Tim">
                </div>
                <div>
                    <label for="telpon" class="text-sm text-gray-700">Nomor Telepon</label>
                    <input type="tel" wire:model="nomor_telepon"
                        class="block w-full py-2.5 px-4 rounded-xl border border-gray-300 focus:border-primary focus:shadow focus:drop-shadow-primary outline-none "
                        placeholder="Isi Nomor Telepon">
                </div>
            </div>

            <button type="submit"
                class="cursor-pointer py-2.5 px-6 rounded-xl bg-primary text-white font-semibold transition hover:bg-primary/90">
                Booking
            </button>
        </form>
    @endif
</div>
