<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            'diet_plan' => 30000,
            'protein_plan' => 40000,
            'royal_plan' => 60000,
        ];

        // 10 pelanggan biasa
        for ($i = 0; $i < 10; $i++) {
            $this->createSubscription();
        }

        // 5 pelanggan dengan 2x langganan (untuk reactivation)
        for ($i = 0; $i < 5; $i++) {
            $name = fake()->name();
            $phone = '08' . rand(1000000000, 9999999999);

            // Langganan pertama (expired)
            $this->createSubscription($name, $phone, now()->subDays(20), -15, -10);

            // Langganan kedua (reactivated)
            $this->createSubscription($name, $phone, now(), 1, 7);
        }
    }

    /**
     * Membuat 1 subscription dengan parameter yang bisa disesuaikan.
     *
     * @param string|null $name
     * @param string|null $phone
     * @param Carbon|null $createdAt
     * @param int $minDayOffset
     * @param int $maxDayOffset
     * @return void
     */
    private function createSubscription(
        ?string $name = null,
        ?string $phone = null,
        ?Carbon $createdAt = null,
        int $minDayOffset = -10,
        int $maxDayOffset = 10
    ): void {
        $name = $name ?? fake()->name();
        $phone = $phone ?? '08' . rand(1000000000, 9999999999);
        $plan = Arr::random(['diet_plan', 'protein_plan', 'royal_plan']);
        $mealTypes = Arr::random(['Breakfast', 'Lunch', 'Dinner'], rand(1, 3));

        $deliveryDays = collect(range(1, rand(3, 5)))
            ->map(fn () => Carbon::now()->addDays(rand($minDayOffset, $maxDayOffset))->format('Y-m-d'))
            ->sort()
            ->values()
            ->toArray();

        $expiredAt = collect($deliveryDays)->max();
        $mealCount = count((array) $mealTypes);
        $dayCount = count($deliveryDays);
        $totalPrice = $mealCount * $dayCount * $this->getPlanPrice($plan) * 4.3;

        Subscription::create([
            'full_name' => $name,
            'phone' => $phone,
            'plan' => $plan,
            'meal_types' => $mealTypes,
            'delivery_days' => $deliveryDays,
            'allergies' => rand(0, 1) ? 'seafood, peanuts' : null,
            'total_price' => $totalPrice,
            'created_at' => $createdAt ?? now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Ambil harga per porsi berdasarkan plan.
     */
    private function getPlanPrice(string $plan): int
    {
        return match ($plan) {
            'diet_plan' => 30000,
            'protein_plan' => 40000,
            'royal_plan' => 60000,
            default => 30000
        };
    }
}
