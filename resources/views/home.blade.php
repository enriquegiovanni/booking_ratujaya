@extends('layouts.app')

@section('header')
    <div class="mt-42">
        <h1 class="text-center text-6xl text-white font-bold">
            SELAMAT DATANG DI GOR Ratu Jaya <br class="hidden md:block">
        </h1>
        <p class="text-center text-white mt-6 w-full md:w-6/12 mx-auto">
          Lapangan Bulu Tangkis berstandar internasional dengan permukaan vinyl sesuai standar BWF, memastikan kenyamanan dan performa terbaik Anda.
        </p>
    </div>
@endsection

@section('content')
    <section id="booking" class="pt-10 md:pt-24">
        <div class="max-w-6xl mx-auto px-4">
            <span
                class="mx-auto w-max py-2 px-6 rounded-full bg-primary text-white text-xs font-semibold flex items-center gap-2">
                <i class="ai-align-left"></i>
                Pilih Lapangan
            </span>
            <h2 class="text-center text-2xl md:text-4xl font-bold mt-3">
                Pilih Lapangan Badminton
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
                @foreach ($lapangan as $item)
                    <a href="{{ route('lapangan.detail', $item->id) }}"
                        class="bg-white border border-transparent rounded-2xl transition hover:border-primary">
                        <img src="{{ asset('storage/' . (is_array($item->images) && count($item->images) > 0 ? $item->images[0] : 'default-lapangan.png')) }}"
                            class="w-full h-60 rounded-t-2xl object-cover" alt="">
                        <div class="p-6">
                            <span
                                class="text-xs w-max py-2 px-6 rounded-full {{ $item->category == 'lapangan1' ? 'bg-tertiary' : 'bg-primary' }} text-white font-semibold flex items-center gap-2">
                                <i class="ai-star"></i>
                                {{ $item->category }}
                            </span>
                            <h4 class="text-xl font-semibold mt-2">{{ $item->title }}</h4>
                            <p class="text-gray-500">
                                Mulai dari Rp. {{ number_format($item->price) }} <span class="text-xs">/jam</span>
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    <section class="pt-10 md:pt-24">
        <div class="max-w-6xl mx-auto px-4">
            <span
                class="mx-auto w-max py-2 px-6 rounded-full bg-primary text-white text-xs font-semibold flex items-center gap-2">
                <i class="ai-info"></i>
                How To Booking
            </span>
            <h2 class="text-center text-2xl md:text-4xl font-bold mt-3">
                Cara Booking
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
                <div class="bg-white rounded-2xl p-14 text-center">
                    <span class="mx-auto p-6 w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center">
                        1
                    </span>
                    <h5 class="font-semibold text-2xl mt-4">
                        Pilih Lapangan
                    </h5>
                </div>
                <div class="bg-white rounded-2xl p-14 text-center">
                    <span class="mx-auto p-6 w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center">
                        2
                    </span>
                    <h5 class="font-semibold text-2xl mt-4">
                        Pilih Tanggal & Jam
                    </h5>
                </div>
                <div class="bg-white rounded-2xl p-14 text-center">
                    <span class="mx-auto p-6 w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center">
                        3
                    </span>
                    <h5 class="font-semibold text-2xl mt-4">
                        Isi Nama & No HP
                    </h5>
                </div>
            </div>
        </div>
    </section>
    <section class="pt-10 md:pt-24">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <span class="mx-auto w-max py-2 px-6 rounded-full bg-primary text-white text-xs font-semibold flex items-center gap-2">
            <i class="ai-image"></i>
            Tentang Kami
        </span>
        <h2 class="text-2xl md:text-4xl font-bold mt-3">Tentang Kami</h2>

        <p class="mt-4 text-gray-700 text-lg md:text-xl leading-relaxed max-w-3xl mx-auto">
    GOR Ratu Jaya adalah pusat olahraga bulu tangkis yang hadir untuk memenuhi kebutuhan masyarakat akan fasilitas olahraga yang nyaman, terjangkau, dan berstandar tinggi.
</p>

        <!-- Tambahkan paragraf lainnya di sini -->
    </div>
</section>
    <section class="py-10 md:py-24">
        <div class="max-w-6xl mx-auto px-4">
            <span
                class="mx-auto w-max py-2 px-6 rounded-full bg-primary text-white text-xs font-semibold flex items-center gap-2">
                <i class="ai-phone"></i>
                Contact Us
            </span>
            <h2 class="text-center text-2xl md:text-4xl font-bold mt-3">
                Hubungi Kami
            </h2>

            <div class="flex flex-col md:flex-row gap-6 mt-10">
                <div class="w-4/12">
                    <div class="rounded-xl p-6 bg-white ">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="rounded-full bg-primary text-white p-2 w-10 h-10 flex items-center justify-center">
                                <i class="ai-whatsapp-fill"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-semibold">Whatsapp</span>
                                <span class="text-xs">+62 812-3456-7890</span>
                            </div>
                        </div>
                        <!-- email -->
                        <div class="flex items-center gap-4 mb-4">
                            <div class="rounded-full bg-primary text-white p-2 w-10 h-10 flex items-center justify-center">
                                <i class="ai-envelope"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-semibold">Email</span>
                                <span class="text-xs">admin@ratujaya.com</span>
                            </div>
                        </div>
                        <!-- Address -->
                        <div class="flex items-center gap-4">
                            <div class="rounded-full bg-primary text-white p-2 w-10 h-10 flex items-center justify-center">
                                <i class="ai-map"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-semibold">Alamat</span>
                                <span class="text-xs">Jl. Raya Citayam No.96, Ratu Jaya,</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rounded-xl bg-white w-8/12">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3964.783235403286!2d106.8133592!3d-6.4218914!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69e97f6b8dbfa5%3A0x50b4a7c96eba6b36!2sGOR%20Ratu%20Jaya!5e0!3m2!1sid!2sid!4v1752663759639!5m2!1sid!2sid" 
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
@endsection
