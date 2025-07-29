<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOR Ratu Jaya</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Icon Fonts -->
    <script src="https://unpkg.com/akar-icons-fonts"></script>

    <!-- SweetAlert2 CSS (optional, for better styling) -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <!-- 🔝 HEADER -->
    <header style="background-image: url({{ asset('images/header.jpg') }});"
        class="{{ request()->is('/') ? 'min-h-screen' : 'min-h-[500px]' }} bg-center bg-cover">
        <div class="max-w-6xl mx-auto py-10 px-4">
            <nav class="bg-white rounded-xl py-4 px-6">
                <div class="flex items-center justify-between">
                    <a href="{{ route('home') }}" class="text-base md:text-lg font-bold">GOR Ratu Jaya</a>
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('home') }}"
                            class="py-2.5 px-3 md:px-6 rounded-xl bg-white text-black font-semibold transition hover:bg-primary/90 hover:text-white">Home</a>
                        <a href="{{ url('/#booking') }}"
                            class="py-2.5 px-3 md:px-6 rounded-xl bg-white text-black font-semibold transition hover:bg-primary/90 hover:text-white">Booking</a>

                </div>
            </nav>
            @yield('header')
        </div>
    </header>

    <!-- 💬 CONTENT -->
    @yield('content')

    <!-- ⏬ FOOTER -->
  <footer class="py-6 bg-[#101C1C]">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-center">
            <p class="text-white text-sm text-center">
                &copy; Copyright 2025. GOR Ratu Jaya
            </p>
        </div>
    </div>
</footer>


    <!-- 🔔 SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Pop-up sukses
        window.addEventListener('swal:success', event => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: event.detail.message,
                confirmButtonColor: '#3085d6',
            });
        });

        // Pop-up error
        window.addEventListener('swal:error', event => {
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: event.detail.message,
                confirmButtonColor: '#d33',
            });
        });
    </script>
</body>

</html>
