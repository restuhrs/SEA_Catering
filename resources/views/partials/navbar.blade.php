<!-- Hamburger Button - only mobile -->
<button id="toggleSidebar" class="text-white md:hidden mr-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
    </svg>
</button>

<!-- Sidebar Menu (hidden by default, only on mobile) -->
<div id="sidebarMenu"
     class="fixed inset-y-0 right-0 w-64 bg-green-600 text-white transform translate-x-full transition-transform ease-in-out duration-300 z-50 md:hidden overflow-y-auto">
    <div class="p-4">
        <div class="flex justify-between items-center mb-4">

            <div class="flex items-center space-x-4">
                <img src="{{ asset('storage/assets/images/logo.jpg') }}" alt="SEA logo" class="w-10 h-10 rounded-full object-cover">
                <h2 class="text-xl font-bold">SEA Catering</h2>
            </div>

            <button id="closeSidebar" class="text-white text-2xl font-bold mb-10">&times;</button>
        </div>
        <ul class="space-y-3">
            <li class="flex items-center gap-4">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <a href="/home" class="block hover:underline">Home</a>
            </li>
            <li class="flex items-center gap-4">
                <i data-lucide="calendar-check" class="w-5 h-5"></i>
                <a href="/meal-plans" class="block hover:underline">Meal Plans</a>
            </li>
            <li class="flex items-center gap-4">
                <i data-lucide="users-round" class="w-5 h-5"></i>
                <a href="/testimonials" class="block hover:underline">Testimonials</a>
            </li>
            <li class="flex items-center gap-4">
                <i data-lucide="bookmark-check" class="w-5 h-5"></i>
                <a href="/subscription" class="block hover:underline">Subscribe</a>
            </li>

            <li class="flex items-center gap-4">
                @auth
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-fit text-left bg-gradient-to-r from-green-400 to-green-600 hover:from-green-300 hover:to-green-500 hover:text-green-800 border border-white py-1 px-4 rounded-2xl transition">Logout</button>
                    </form>
                @else
                    <i data-lucide="log-in" class="w-5 h-5"></i>
                    <a href="{{ route('login') }}" class="block w-fit bg-white text-green-700 px-4 py-1 rounded-2xl hover:bg-gray-100 transition">Login</a>
                @endauth
            </li>
        </ul>
    </div>
</div>

<!-- Overlay -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40 md:hidden"></div>

<!-- Horizontal Navbar (desktop only) -->
<nav class="hidden md:flex items-center">
    <ul class="flex items-center space-x-4">
        <li>
            <a href="{{ route('home') }}"
               class="block transition border-b-2 underline-offset-2
                      {{ Request::routeIs('home') ? 'border-white text-white' : 'border-transparent hover:text-green-800' }}">
                Home
            </a>
        </li>
        <li>
            <a href="{{ url('/meal-plans') }}"
               class="block transition border-b-2 underline-offset-2
                      {{ Request::is('meal-plans') ? 'border-white text-white' : 'border-transparent hover:text-green-800' }}">
                Meal Plans
            </a>
        </li>
        <li>
            <a href="{{ route('testimonials') }}"
               class="block transition border-b-2 underline-offset-2
                      {{ Request::routeIs('testimonials') ? 'border-white text-white' : 'border-transparent hover:text-green-800' }}">
                Testimonials
            </a>
        </li>
        <li>
            <a href="{{ route('subscription') }}"
               class="block transition border-b-2 underline-offset-2
                      {{ Request::routeIs('subscription') ? 'border-white text-white' : 'border-transparent hover:text-green-800' }}">
                Subscribe
            </a>
        </li>
    </ul>

    @auth
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="ml-6 bg-gradient-to-r from-green-400 to-green-600 hover:from-green-300 hover:to-green-500 hover:text-green-800 border border-white py-1 px-4 rounded-2xl transition">
                Logout
            </button>
        </form>
    @else
        <a href="{{ route('login') }}"
            class="ml-6 bg-white text-green-700 font-semibold px-4 py-1 rounded-2xl border hover:bg-gray-100 transition">
            Login
        </a>
    @endauth

</nav>


@push('scripts')

<!-- Sidebar for mobile -->
<script>
    const sidebar = document.getElementById('sidebarMenu');
    const overlay = document.getElementById('sidebarOverlay');
    const toggleBtn = document.getElementById('toggleSidebar');
    const closeBtn = document.getElementById('closeSidebar');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.remove('translate-x-full');
        overlay.classList.remove('hidden');
    });

    closeBtn.addEventListener('click', () => {
        sidebar.classList.add('translate-x-full');
        overlay.classList.add('hidden');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.add('translate-x-full');
        overlay.classList.add('hidden');
    });
</script>

<!-- icon sidebar -->
<script>
    lucide.createIcons();
</script>
@endpush
