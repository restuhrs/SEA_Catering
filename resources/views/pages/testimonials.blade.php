@extends('layouts.app')

@section('content')
<section class="bg-[#f8f9ff] py-16">
    <div class="max-w-6xl mx-auto px-4 animate-fade-in">
        <div class="{{ session('success') ? '' : 'animate-fade-in' }}">

            <p class="text-md text-gray-500 text-center mb-2">— Testimonials</p>
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">
                What <span class="text-green-600">Our Customers</span> Say <br>
                About Our Healthy Meals
            </h2>

            <!-- Testimonial Carousel -->
            <div x-data="{
                    active: 0,
                    testimonials: window.testimonialsData,
                    init() {
                        setInterval(() => {
                            this.active = (this.active + 1) % this.testimonials.length;
                        }, 3000);
                    }
                }" x-init="init()">

                <!-- Carousel Container -->
                <div class="relative flex justify-center items-center">

                    <!-- Arrow Left -->
                   <button @click="active = (active - 1 + testimonials.length) % testimonials.length"
                        class="absolute left-0 bg-white rounded-full shadow p-2 hover:bg-gray-100">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <!-- Testimonial Slide -->
                    <template x-for="(testimonial, index) in testimonials" :key="index">
                        <div x-show="active === index" class="bg-white rounded-xl shadow-md p-6 w-full max-w-md transition-all duration-300 text-center">
                            <div class="flex justify-center gap-2 mb-3">
                                <template x-for="i in 5">
                                    <svg :class="i <= testimonial.rating ? 'text-orange-400' : 'text-gray-300'" class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                        <polygon points="9.9,1.1 12.4,6.6 18.3,7.2 13.7,11.2 15.1,17.1 9.9,14 4.8,17.1 6.1,11.2 1.5,7.2 7.4,6.6 " />
                                    </svg>
                                </template>
                                <span class="text-md font-semibold" x-text="testimonial.rating"></span>
                            </div>
                            <p class="text-gray-600 mb-4 text-md italic" x-text="testimonial.message"></p>
                            <div class="flex justify-center items-center gap-3">
                                <img :src="testimonial.photo" class="w-10 h-10 rounded-full object-cover" alt="">
                                <p class="font-bold text-md" x-text="testimonial.name"></p>
                            </div>
                        </div>
                    </template>

                    <!-- Arrow Right -->
                    <button @click="active = (active + 1) % testimonials.length"
                        class="absolute right-0 bg-white rounded-full shadow p-2 hover:bg-gray-100">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                <div x-show="testimonials.length === 0" class="text-center text-gray-500 mt-6">
                    No testimonials yet.
                </div>

                <!-- Dots Navigation -->
                <div class="flex justify-center gap-3 mt-6">
                    <template x-for="(t, i) in testimonials.length">
                        <button class="w-3 h-3 rounded-full" :class="active === i ? 'bg-blue-600' : 'bg-gray-300'" @click="active = i"></button>
                    </template>
                </div>
            </div>

            <!-- Testimonial Form -->
            <div id="feedback-form" class="mt-16 bg-white p-6 rounded-2xl shadow-md max-w-2xl mx-auto">
                <h3 class="text-xl font-semibold mb-4 text-center">Leave Your Feedback</h3>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded-lg mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @auth
                    <form method="POST" action="{{ route('testimonials.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="name" class="block text-md font-medium">Your Name</label>
                            <input type="text" id="name" name="name" autocomplete="name"
                                class="w-full border border-gray-300 px-4 py-2 rounded-md placeholder:text-gray-400"
                                placeholder="Lionel Messi" required>
                        </div>

                        <div>
                            <label for="review" class="block text-md font-medium">Your Review</label>
                            <textarea id="review" name="review" maxlength="200" autocomplete="off"
                                class="w-full border border-gray-300 px-4 py-2 rounded-md placeholder:text-gray-400"
                                rows="3" placeholder="Share your experience..." required
                                oninput="updateCharCount()"></textarea>

                            <div class="text-sm text-gray-400 text-right mt-1" id="charCount">0 / 200</div>
                        </div>

                        <div>
                            <label for="rating" class="block text-md font-medium">Rating 🤩</label>
                            <select id="rating" name="rating" required autocomplete="off"
                                class="w-full border border-gray-300 px-4 py-2 rounded-md mb-4">
                                <option value="">-- Select Rating --</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                        </div>

                        <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">
                            Submit
                        </button>
                    </form>
                @else
                    <p class="text-red-500 text-md">
                        Want to share your experience?
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Login here</a>
                    </p>
                @endauth
            </div>

        </div>
    </div>
</section>
@endsection


@push('scripts')

    <!-- show data testimoni -->
    <script>
         window.testimonialsData = @json($testimoni);
    </script>

    <!-- form testimoni -->
    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const el = document.getElementById('feedback-form');
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    </script>
    @endif

    <!-- input form reviews -->
    <script>
        function updateCharCount() {
            const textarea = document.getElementById('review');
            const counter = document.getElementById('charCount');
            const length = textarea.value.length;
            counter.textContent = `${length} / 200`;
        }

        // Jalankan sekali saat halaman dimuat (kalau textarea ada default value)
        document.addEventListener('DOMContentLoaded', updateCharCount);
    </script>
@endpush
