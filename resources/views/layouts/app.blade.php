<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOR Ratu Jaya</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/akar-icons-fonts"></script>
</head>

<body class="bg-gray-100">
    <header style="background-image: url({{ asset('images/header.jpg') }});"
        class="{{ request()->is('/') ? 'min-h-screen' : 'min-h-[500px]' }} bg-center bg-cover">
        <div class="max-w-6xl mx-auto py-10 px-4">
            <nav class="bg-white rounded-xl py-4 px-6">
                <div class="flex items-center justify-between">
                    <a href="{{ route('home') }}" class="text-base md:text-lg font-bold">GOR Ratu Jaya</a>
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('home') }}"
                            class="py-2.5 px-3 md:px-6 rounded-xl bg-white text-black font-semibold transition hover:bg-primary/90 hover:text-white">Home</a>
                        <a href="#booking"
                            class="py-2.5 px-3 md:px-6 rounded-xl bg-white text-black font-semibold transition hover:bg-primary/90 hover:text-white">Booking</a>
                        <a href="{{ url('/admin/login') }}" class="py-2.5 px-3 md:px-6 rounded-xl bg-white text-black font-semibold transition hover:bg-primary/90 hover:text-white">Login</a>
                    </div>
                </div>
            </nav>
            @yield('header')
        </div>
    </header>

    @yield('content')

    <footer class="py-6 bg-[#101C1C]">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-between">
                <p class="text-white text-sm">&copy; Copyright 2025. GOR Ratu Jaya</p>
                <div class="flex gap-4 justify-end">
                    <a href="#" target="_blank" class="text-white text-base hover:text-primary transition">
                        <i class="ai-whatsapp-fill"></i>
                    </a>
                    <a href="#" target="_blank" class="text-white text-base hover:text-primary transition">
                        <i class="ai-instagram-fill"></i>
                    </a>
                    <a href="#" target="_blank" class="text-white text-base hover:text-primary transition">
                        <i class="ai-youtube-fill"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
