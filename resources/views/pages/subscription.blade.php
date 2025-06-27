@extends('layouts.app')

@section('content')
<section class="bg-white py-12">
    <div class="max-w-4xl mx-auto px-4 animate-fade-in">

        <h2 class="text-3xl font-bold mb-6 text-center"><span class="text-green-600">Subscribe</span> to Meal Plan</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form id="subscriptionForm" action="{{ route('subscribe.store') }}" method="POST" class="space-y-6 bg-white p-8 shadow-lg rounded-2xl border border-gray-100">
            @csrf

            <div>
                <label class="block font-semibold">Full Name*</label>
                <input type="text" name="full_name"
                    value="{{ $user->name }}"
                    readonly
                    class="w-full bg-gray-100 text-gray-600 border border-gray-300 rounded-md p-2 cursor-not-allowed" />
            </div>

            <div>
                <label class="block font-semibold">Phone Number*</label>
                <input type="text" name="phone"
                    value="{{ $user->phone }}"
                    readonly
                    class="w-full bg-gray-100 text-gray-600 border border-gray-300 rounded-md p-2 cursor-not-allowed" />
            </div>

            <div>
                <label class="block font-semibold">Select Plan*</label>
                <select id="plan" name="plan" required class="w-full border border-gray-300 rounded-md p-2">
                    <option value="diet_plan">Diet Plan – Rp30.000</option>
                    <option value="protein_plan">Protein Plan – Rp40.000</option>
                    <option value="royal_plan">Royal Plan – Rp60.000</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-2">Meal Types*</label>
                <div class="flex gap-6">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="meal_types[]" class="form-checkbox border border-gray-300 rounded-full text-green-600 w-5 h-5 meal-type" value="Breakfast" />
                        <span>Breakfast</span>
                    </label>
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="meal_types[]" class="form-checkbox border border-gray-300 rounded-full text-green-600 w-5 h-5 meal-type" value="Lunch" />
                        <span>Lunch</span>
                    </label>
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="meal_types[]" class="form-checkbox border border-gray-300 rounded-full text-green-600 w-5 h-5 meal-type" value="Dinner" />
                        <span>Dinner</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block font-semibold mb-2">Delivery Days*</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                    @foreach($deliveryDates as $item)
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="delivery_days[]" value="{{ $item['full'] }}"
                                class="form-checkbox border border-gray-300 rounded-full text-blue-600 w-5 h-5 delivery-day">
                            <span>{{ $item['day'] }} ({{ $item['date'] }})</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="inline-flex items-center gap-2 mt-4">
                    <input type="checkbox" id="one_week" name="subscribe_for_week"
                    class="form-checkbox border border-gray-300 rounded-full text-blue-600 w-5 h-5">
                    <span>Subscribe for 1 Week </span>
                </label>
            </div>

            <div>
                <label class="block font-semibold">Allergies or Ingredients to Avoid</label>
                <textarea name="allergies" class="w-full border border-gray-300 rounded-md placeholder:text-gray-400 p-2" rows="3"
                placeholder="peanuts, milk, seafood (optional)"></textarea>
            </div>

            <!-- price -->
            <input type="hidden" name="total_price" id="total_price_input" />
            <div id="result" class="mt-6 text-center text-xl font-semibold"></div>

            <div class="flex flex-col sm:flex-row sm:justify-between gap-3 mb-4">
                <button type="button" onclick="calculateTotal()" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Calculate Total
                </button>

                <button type="button" onclick="confirmSubmit()" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                    Submit & Download Invoice
                </button>
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-between gap-3">
                <button type="button" onclick="showDetails()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-800">
                    Check Order
                </button>

                <button type="button" onclick="showPreviousDetail()" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
                    Subscribe History
                </button>

                <div id="previousDetailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                    <div class="bg-white rounded-lg p-6 w-full max-w-xl shadow-xl relative overflow-y-auto max-h-[90vh]">

                        <button type="button" onclick="closePreviousModal()" class="absolute top-2 right-3 text-gray-600 hover:text-red-500 text-4xl">&times;</button>
                        <h3 class="text-lg font-bold mb-4 text-center text-green-600">Subscription History</h3>

                        @if ($subscriptions->isEmpty())
                            <p class="text-center text-gray-500">You have no subscription history yet.</p>
                        @else
                            @foreach ($subscriptions as $subs)
                                <div class="border rounded-lg p-4 mb-4 bg-gray-50 shadow-sm">
                                    <ul class="text-sm text-gray-700 space-y-1">
                                        <li><strong>Name:</strong> {{ $subs->full_name }}</li>
                                        <li><strong>Phone:</strong> {{ $subs->phone }}</li>
                                        <li><strong>Plan:</strong> {{ ucwords(str_replace('_', ' ', $subs->plan)) }}</li>
                                        <li><strong>Meal Types:</strong> {{ implode(', ', (array)$subs->meal_types) }}</li>
                                        <li><strong>Delivery:</strong>
                                            {{ collect($subs->delivery_days)->map(fn($d) => \Carbon\Carbon::parse($d)->format('l (d M Y)'))->join(', ') }}
                                        </li>
                                        <li><strong>Total:</strong> Rp{{ number_format($subs->total_price, 0, ',', '.') }}</li>
                                        <p><strong>Status:</strong> {{ $subs->status }}</p>
                                        <p><strong>Ends on:</strong> {{ $subs->active_until }}</p>
                                    </ul>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </form>

        <!-- Modal : check order -->
        <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-xl relative">
                <button onclick="closeModal()" class="absolute top-2 right-3 text-gray-600 hover:text-red-500 text-4xl">&times;</button>
                <h3 class="text-lg font-bold mb-4 text-center text-green-700">Check Order Detail</h3>
                <ul class="text-gray-700 space-y-2 text-sm">
                    <li><strong>Name:</strong> <span id="detailName"></span></li>
                    <li><strong>Phone:</strong> <span id="detailPhone"></span></li>
                    <li><strong>Plan:</strong> <span id="detailPlan"></span></li>
                    <li><strong>Meal Type:</strong> <span id="detailMeals"></span></li>
                    <li><strong>Delivery:</strong> <span id="detailDays"></span></li>
                    <li><span id="detailTotal"></span></li>
                </ul>
            </div>
        </div>

    </div>

</section>
@endsection

@push('scripts')

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmSubmit() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to subscribe and download invoice.",
            icon: 'question',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#16a34a', // green
            cancelButtonText: 'Cancel',
            confirmButtonText: 'Yes, Submit',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('subscriptionForm').submit();
            }
        });
    }
</script>

<!-- calculate total -->
<script>
    function calculateTotal() {
        const plan = document.getElementById('plan').value;

        const planPrices = {
            diet_plan: 30000,
            protein_plan: 40000,
            royal_plan: 60000
        };

        const planPrice = planPrices[plan];
        const mealTypes = document.querySelectorAll('.meal-type:checked').length;
        const deliveryDays = document.querySelectorAll('.delivery-day:checked').length;

        if (mealTypes < 1 || deliveryDays < 1) {
            alert('Please select at least one meal type and one delivery day.');
            return;
        }

        const total = planPrice * mealTypes * deliveryDays * 4.3;

        // tampilkan dan simpan ke input hidden
        document.getElementById('result').textContent = 'Total Price: Rp' + total.toLocaleString('id-ID');
        document.getElementById('total_price_input').value = total;
    }
</script>

<!-- otomatis subs one week -->
<script>
    document.getElementById('one_week').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.delivery-day');
        checkboxes.forEach(c => c.checked = false);

        if (this.checked) {
            for (let i = 0; i < 7 && i < checkboxes.length; i++) {
                checkboxes[i].checked = true;
            }
        }
    });
</script>

<!-- show detail check order -->
<script>
    function showDetails() {
        const name = document.querySelector('[name="full_name"]').value;
        const phone = document.querySelector('[name="phone"]').value;
        const plan = document.querySelector('#plan').selectedOptions[0].text;
        const meals = Array.from(document.querySelectorAll('.meal-type:checked')).map(cb => cb.value).join(', ');
        const days = Array.from(document.querySelectorAll('.delivery-day:checked')).map(cb => cb.nextElementSibling.textContent).join(', ');
        const total = document.getElementById('result').textContent;

        document.getElementById('detailName').textContent = name;
        document.getElementById('detailPhone').textContent = phone;
        document.getElementById('detailPlan').textContent = plan;
        document.getElementById('detailMeals').textContent = meals;
        document.getElementById('detailDays').textContent = days;
        document.getElementById('detailTotal').textContent = total;

        document.getElementById('detailModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }
</script>

<!-- subs history close button -->
<script>
    function showPreviousDetail() {
        document.getElementById('previousDetailModal').classList.remove('hidden');
    }

    function closePreviousModal() {
        document.getElementById('previousDetailModal').classList.add('hidden');
    }
</script>
@endpush
