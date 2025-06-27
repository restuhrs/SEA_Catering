<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - SEA Catering</title>
    <link rel="icon" href="{{ asset('storage/assets/images/logo.jpg') }}" type="image/jpeg">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .video-background {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            object-fit: cover;
            opacity: 0.8;
            z-index: -1;
        }
        .form-container {
            position: relative;
            z-index: 2;
        }
    </style>
</head>
<body class="min-h-screen bg-black text-white overflow-hidden relative">
    <video autoplay muted loop class="video-background">
        <source src="{{ asset('storage/assets/videos/bg-auth.MP4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <section class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white bg-opacity-90 text-gray-800 p-6 sm:p-8 rounded-lg shadow-md w-full max-w-md form-container">
            <div class="text-center mb-6">
                <a href="{{ route('login') }}" class="flex items-center text-sm text-green-600 hover:underline mb-3 justify-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <img src="{{ asset('storage/assets/images/logo.jpg') }}" class="h-24 w-24 mx-auto rounded-full object-cover mb-2" alt="Logo">
                <h2 class="text-2xl font-bold text-green-600 mb-2">Create an account</h2>
                <p class="text-sm text-gray-500">Register to subscribe to meal plans</p>
            </div>
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-800 text-sm p-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('register.action') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium">Full Name</label>
                    <div class="relative">
                        <input type="text" name="name" autocomplete="name" class="w-full border border-gray-300 rounded-lg placeholder:text-gray-400 p-2 pl-10 pr-10 mt-1" placeholder="Your Name" required />
                        <span class="absolute left-3 top-3 text-gray-400">
                            <i class="fas fa-user"></i>
                        </span>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium">Phone Number</label>
                    <div class="relative">
                        <input type="tel" name="phone" autocomplete="tel" class="w-full border border-gray-300 rounded-lg placeholder:text-gray-400 p-2 pl-10 pr-10 mt-1" placeholder="081234567890" required />
                        <span class="absolute left-3 top-3 text-gray-400">
                            <i class="fas fa-phone"></i>
                        </span>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium">Email</label>
                    <div class="relative">
                        <input type="email" name="email" autocomplete="email" class="w-full border border-gray-300 rounded-lg placeholder:text-gray-400 p-2 pl-10 pr-10 mt-1" placeholder="you@example.com" required />
                        <span class="absolute left-3 top-3 text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium">Password</label>
                    <div class="relative">
                        <input type="password" id="register-password" name="password" autocomplete="new-password" class="w-full border border-gray-300 rounded-lg placeholder:text-gray-400 p-2 pl-10 pr-10 mt-1" placeholder="password" required>
                        <span class="absolute left-3 top-3 text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <button type="button" onclick="togglePassword('register-password', this)" class="absolute right-3 top-3 text-gray-400 focus:outline-none">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        <p class="text-xs text-red-600 mt-1">
                            <span class="block ml-2">• One uppercase letter (A-Z)</span>
                            <span class="block ml-2">• One lowercase letter (a-z)</span>
                            <span class="block ml-2">• One number (0-9)</span>
                            <span class="block ml-2">• One special character (@$!%*?&#)</span>
                        </p>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg transition">
                    Register
                </button>
                <p class="text-sm text-center text-gray-600 mt-4">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-green-600 hover:underline">Login</a>
                </p>
            </form>
        </div>
    </section>

    <!-- show/hide password -->
    <script>
        function togglePassword(fieldId, button) {
            const input = document.getElementById(fieldId);
            const icon = button.querySelector('i');
            const isPassword = input.getAttribute('type') === 'password';
            input.setAttribute('type', isPassword ? 'text' : 'password');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }
    </script>
</body>
</html>
