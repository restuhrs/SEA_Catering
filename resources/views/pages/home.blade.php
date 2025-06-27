@extends('layouts.app')

@section('content')

<!-- Hero Section -->
<section class="relative bg-green-50">
    <div class="max-w-6xl mx-auto px-6 py-24 grid grid-cols-1 md:grid-cols-2 items-center gap-12 animate-fade-in">
        <!-- Text -->
        <div>
            <h1 class="text-4xl md:text-5xl font-bold text-green-900 leading-tight mb-4">Healthy Meals Delivered Straight <br>to Your Hands</h1>
            <p class="text-gray-700 text-lg mb-6">Fresh. Nutritious. Affordable. Start your healthy journey with us today.</p>
            <a href="{{ route('meal-plans') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-full transition">
                Get Started
            </a>
        </div>

        <!-- Image -->
        <div class="block">
            <img src="{{ asset('storage/assets/images/menu_example.jpg') }}" alt="Healthy Meals" class="rounded-xl shadow-lg">
        </div>
    </div>
</section>

<!-- Slogan -->
<section class="text-center py-10 px-4">
    <h2 class="text-xl italic text-green-700 animate-fade-in">"Healthy Meals, Anytime, Anywhere"</h2>
</section>

<!-- About Section -->
<section class="bg-white py-16">
    <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-10 items-center px-4">
        <div>
            <img src="{{ asset('storage/assets/images/kurir.jpg') }}" alt="About SEA Catering" class="rounded-lg shadow-md">
        </div>
        <div>
            <h2 class="text-3xl font-bold text-green-900 mb-4">Why Choose SEA Catering?</h2>
            <p class="text-gray-600 text-lg mb-4">
                We provide customizable healthy meals delivered right to your door — across cities in Indonesia.
                Whether you're aiming for a healthier lifestyle or simply want delicious, nutritious food,
                SEA Catering is your go-to solution.
            </p>
            <a href="{{ route('testimonials') }}" class="text-green-600 font-semibold hover:underline">See Reviews →</a>
        </div>
    </div>
</section>

<!-- Services / Features -->
<section class="bg-gray-50 py-16">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <h3 class="text-3xl font-bold mb-12 text-green-900">Our Services</h3>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition">
                <img src="{{ asset('storage/assets/images/customize-menu.jpg') }}" alt=""
                     class="h-48 w-full object-cover rounded-lg mb-4">
                <h4 class="font-semibold text-lg mb-2">Meal Customization</h4>
                <p class="text-gray-600">Pick meals that suit your taste and health goals.</p>
            </div>
            <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition">
                <img src="{{ asset('storage/assets/images/delivery-food.jpg') }}" alt=""
                     class="h-48 w-full object-cover rounded-lg mb-4">
                <h4 class="font-semibold text-lg mb-2">Nationwide Delivery</h4>
                <p class="text-gray-600">Fast and reliable delivery to cities all over Indonesia.</p>
            </div>
            <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition">
                <img src="{{ asset('storage/assets/images/nutrition.jpg') }}" alt=""
                     class="h-48 w-full object-cover rounded-lg mb-4">
                <h4 class="font-semibold text-lg mb-2">Nutrition Information</h4>
                <p class="text-gray-600">Learn what’s in your meals from calories to nutrients.</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="bg-green-600 py-16 text-white text-center px-4">
    <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Eat Healthier?</h2>
        <p class="text-lg mb-6">Start your weekly meal subscription now and enjoy fresh, healthy dishes every day.</p>
        <a href="{{ auth()->check() && auth()->user()->role === 'customer' ? route('subscription') : route('login') }}"
        class="bg-white text-green-600 font-semibold px-8 py-3 rounded-full hover:bg-gray-100 transition">
            Subscribe Now
        </a>
</section>
@endsection
