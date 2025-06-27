@extends('layouts.app')

@section('content')
<section class="py-12 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 animate-fade-in">
        <h2 class="text-3xl font-bold text-center mb-10">Our <span class="text-green-600">Meal Plans</span></h2>

        <!-- Week Navigation -->
        <div class="flex justify-center gap-2 flex-wrap mb-10">
            @foreach ($weeks as $week)
                <div class="text-center border px-6 py-2 rounded-xl
                    {{ $week['active'] ? 'bg-black text-white font-bold' : 'bg-white text-black' }}">
                    <div class="text-sm">{{ $week['display'] }}</div>
                    <div class="text-md font-semibold">{{ $week['dates'] }}</div>
                </div>
            @endforeach
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($mealPlans as $plan)
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">

                    <div class="relative inline-block">
                        <img src="{{ $plan['image'] }}" class="rounded-2xl mb-4" alt="{{ $plan['name'] }}">

                        @if(isset($plan['tag']))
                            <span class="absolute top-2 right-2 bg-blue-400 text-white text-xs font-semibold px-2 py-1 rounded-full shadow">
                                {{ $plan['tag'] }}
                            </span>
                        @endif
                    </div>

                    <h3 class="text-xl font-semibold mb-1">{{ $plan['name'] }}</h3>
                    <p class="text-gray-600 mb-2">Rp{{ number_format($plan['price'], 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-500 mb-4">{{ Str::limit($plan['description'], 100) }}</p>
                    <button onclick="showModal({{ $loop->index }})" class="bg-green-500 text-white py-2 px-4 rounded-2xl hover:bg-green-600 transition">
                        See More Details</button>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal : Meal Plans -->
    @foreach ($mealPlans as $plan)
        <div id="modal-{{ $loop->index }}" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 justify-center items-center">
            <div class="bg-white max-w-lg w-full p-6 rounded shadow relative">
                <button onclick="closeModal({{ $loop->index }})" class="absolute top-2 right-4 text-gray-600 hover:text-red-500 text-4xl">&times;</button>
                <h3 class="text-2xl font-bold mb-2">{{ $plan['name'] }}</h3>
                <p class="text-gray-700 mb-4">Rp{{ number_format($plan['price'], 0, ',', '.') }}</p>
                <p class="text-green-600 mb-4">{{ $plan['type'] }} ✅</p>
                <p class="text-gray-600 mb-7">{{ $plan['description'] }}</p>
                <p class="text-green-600 mb-7">Delivery : {{ $plan['delivery'] }} ✅</p>

                @if(isset($plan['nutrition']))
                    <div class="mb-4">
                        <h4 class="font-semibold text-md mb-1 text-gray-700">Nutrition Info</h4>
                        <ul class="text-sm text-gray-600 list-disc list-inside space-y-1">
                            @foreach($plan['nutrition'] as $label => $value)
                                <li><strong>{{ $label }}:</strong> {{ $value }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(!empty($plan['ingredients']))
                    <div>
                        <h4 class="font-semibold text-md mb-1 text-gray-700">Ingredients</h4>
                        <p class="text-sm text-gray-600">{{ $plan['ingredients'] }}</p>
                    </div>
                @endif
            </div>
        </div>
    @endforeach

</section>
@endsection

<!-- show/close modal -->
@push('scripts')
<script>
    function showModal(id) {
        document.getElementById(`modal-${id}`).classList.remove('hidden');
        document.getElementById(`modal-${id}`).classList.add('flex');
    }

    function closeModal(id) {
        document.getElementById(`modal-${id}`).classList.add('hidden');
        document.getElementById(`modal-${id}`).classList.remove('flex');
    }
</script>
@endpush
