<!-- Hamburger Button - only mobile -->
<button id="toggleSidebar" class="text-white md:hidden mr-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16" />
    </svg>
</button>

<!-- Hamburger button desktop pada layouts/app -->

<!-- Desktop Sidebar (only for md and above) -->
<aside id="desktopSidebar" class="hidden md:block fixed top-0 left-0 h-full w-64 bg-green-700 text-white z-40 transform -translate-x-full transition-transform duration-300 ease-in-out">
    <div class="p-4">
        <div class="flex justify-end">
            <button id="desktopCloseSidebar" class="text-white text-2xl font-bold hover:text-red-400">&times;</button>
        </div>

        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('storage/assets/images/logo.jpg') }}" alt="SEA logo" class="w-10 h-10 rounded-full object-cover">
                <h2 class="text-xl font-bold">SEA Catering</h2>
            </div>

        </div>

        <ul class="space-y-4 mt-8">
            <li class="flex items-center gap-4">
                <i data-lucide="scroll-text" class="w-5 h-5"></i>
                <a href="#reports" class="hover:underline">Reports</a>
            </li>
            <li class="flex items-center gap-4">
                <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                <a href="#subscription-chart" class="hover:underline">Chart</a>
            </li>
            <li class="flex items-center gap-4">
                <i data-lucide="table" class="w-5 h-5"></i>
                <a href="#recent-subscriptions" class="hover:underline">Table</a>
            </li>

            @auth
            <li class="flex items-center gap-4">
                <i data-lucide="log-out" class="w-5 h-5"></i>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-fit text-left bg-gradient-to-r from-green-400 to-green-600 hover:from-green-300 hover:to-green-500 hover:text-green-800 border border-white py-1 px-4 rounded-2xl transition">
                        Logout
                    </button>
                </form>
            </li>
            @endauth
        </ul>
    </div>
</aside>

<!-- Sidebar (Mobile only) -->
<div id="sidebarMenu"
     class="fixed inset-y-0 right-0 w-64 bg-green-700 text-white transform translate-x-full transition-transform ease-in-out duration-300 z-50 md:hidden overflow-y-auto">
    <div class="p-4">
        <div class="flex justify-end">
            <button id="closeSidebar" class="text-white text-2xl font-bold hover:text-red-400">&times;</button>
        </div>
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('storage/assets/images/logo.jpg') }}" alt="SEA logo" class="w-10 h-10 rounded-full object-cover">
                <h2 class="text-xl font-bold">SEA Catering</h2>
            </div>
        </div>

        <ul class="space-y-3 mt-8">
            <li class="flex items-center gap-4">
                <i data-lucide="scroll-text" class="w-5 h-5"></i>
                <a href="#reports" class="block hover:underline">Reports</a>
            </li>
            <li class="flex items-center gap-4">
                <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                <a href="#subscription-chart" class="block hover:underline">Chart</a>
            </li>
            <li class="flex items-center gap-4">
                <i data-lucide="table" class="w-5 h-5"></i>
                <a href="#recent-subscriptions" class="block hover:underline">Table</a>
            </li>

            @auth
            <li class="flex items-center gap-4">
                <i data-lucide="log-out" class="w-5 h-5"></i>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-fit text-left bg-gradient-to-r from-green-400 to-green-600 hover:from-green-300 hover:to-green-500 hover:text-green-800 border border-white py-1 px-4 rounded-2xl transition">
                        Logout
                    </button>
                </form>
            </li>
            @endauth
        </ul>
    </div>
</div>



<!-- Overlay -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40 md:hidden"></div>

<!-- Horizontal Navbar (desktop only) -->
<nav class="hidden md:flex items-center ml-auto space-x-6">
    <ul class="flex items-center space-x-4">
        <!-- Profile section -->
        <li class="flex items-center space-x-2">
            <!-- <img src="{{ asset('storage/assets/images/restu.jpg') }}"
                 alt="Admin Avatar"
                 class="w-8 h-8 rounded-full object-cover border border-white shadow" /> -->

            <span class="w-fit text-left bg-gradient-to-r from-green-400 to-green-600 hover:from-green-300 hover:to-green-500 hover:text-green-800 border border-white py-1 px-4 rounded-2xl transition">Admin</span>
        </li>
    </ul>
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

<!-- sidebar desktop -->
<script>
    const desktopSidebar = document.getElementById('desktopSidebar');
    const desktopToggle = document.getElementById('desktopToggleSidebar');
    const desktopClose = document.getElementById('desktopCloseSidebar');
    const mainContent = document.getElementById('mainContent');

    desktopToggle?.addEventListener('click', () => {
        desktopSidebar.classList.remove('-translate-x-full');
        mainContent.classList.remove('md:ml-0');
        mainContent.classList.add('md:ml-64'); // Geser konten ke kanan
    });

    desktopClose?.addEventListener('click', () => {
        desktopSidebar.classList.add('-translate-x-full');
        mainContent.classList.remove('md:ml-64'); // Kembalikan posisi semula
        mainContent.classList.add('md:ml-0');
    });

</script>

<!-- icon sidebar -->
<script>
    lucide.createIcons();
</script>

@endpush
