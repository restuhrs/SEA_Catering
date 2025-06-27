<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - SEA Catering</title>
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
                <img src="{{ asset('storage/assets/images/logo.jpg') }}" class="h-24 w-24 mx-auto rounded-full object-cover mb-6" alt="Logo">
                <h2 class="text-2xl font-bold text-green-600 mb-2">Login</h2>
                <p class="text-md text-gray-500">Hey 👋, Welcome Back</p>
            </div>
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-800 text-sm p-3 rounded-lg mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('login.action') }}">
                @csrf
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
                        <input type="password" id="login-password" name="password" autocomplete="current-password" class="w-full border border-gray-300 rounded-lg placeholder:text-gray-400 p-2 pl-10 pr-10 mt-1" placeholder="password" required>
                        <span class="absolute left-3 top-3 text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <button type="button" onclick="togglePassword('login-password', this)" class="absolute right-3 top-3 text-gray-400 focus:outline-none">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg transition">
                    Login
                </button>
                <p class="text-sm text-center text-gray-600 mt-4">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-green-600 hover:underline">Register</a>
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
