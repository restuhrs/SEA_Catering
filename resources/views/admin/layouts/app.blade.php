<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SEA Catering</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('storage/assets/images/logo.jpg') }}" type="image/jpeg">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Tailwind + JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-800 font-Poppins">

     <!-- Header -->
    <header class="bg-gradient-to-r from-green-500 via-green-400 to-green-800 text-white shadow-md">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">

                <!-- Desktop Hamburger Button (hidden on mobile) -->
                <button id="desktopToggleSidebar" class="hidden md:block text-white mr-4">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <img src="{{ asset('storage/assets/images/logo.jpg') }}"
                 alt="SEA Logo"
                 class="w-10 h-10 rounded-full object-cover">

                <h1 class="text-2xl font-bold">SEA Catering</h1>
            </div>

             <!-- Navbar -->
            @include('admin.partials.navbar')

        </div>
    </header>

    <!-- Main Content -->
    <main id="mainContent" class="transition-all duration-300 md:ml-0">
        @yield('content')
    </main>


    <!-- Include Footer -->
    @include('admin.partials.footer')

    <!-- Global Scripts -->
    @stack('scripts')

</body>
</html>
