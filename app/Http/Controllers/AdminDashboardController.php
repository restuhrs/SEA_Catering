<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->start_date ?? now()->startOfMonth()->toDateString();
        $end = $request->end_date ?? now()->endOfMonth()->toDateString();

        // Ambil semua subscription
        $allSubs = Subscription::orderBy('created_at')->get();

        // Cari langganan baru dalam rentang waktu
        $subscriptions = $allSubs->filter(function ($sub) use ($start, $end) {
            foreach ($sub->delivery_days as $date) {
                if ($date >= $start && $date <= $end) {
                    return true;
                }
            }
            return false;
        });

        $newSubscriptions = $subscriptions->count();
        $activeNewSubscriptions = $subscriptions->filter(function ($sub) {
            return collect($sub->delivery_days)->contains(fn($date) => Carbon::parse($date)->isFuture());
        });

        $inactiveNewSubscriptions = $subscriptions->filter(function ($sub) {
            return collect($sub->delivery_days)->every(fn($date) => Carbon::parse($date)->isPast());
        });
        $totalRevenue = $subscriptions->sum('total_price');
        $activeSubscriptions = $allSubs->filter(function ($sub) {
            foreach ($sub->delivery_days as $date) {
                if (Carbon::parse($date)->isFuture()) {
                    return true;
                }
            }
            return false;
        })->count();

        $latestDeliveryDate = $allSubs
        ->flatMap(fn($sub) => $sub->delivery_days)
        ->map(fn($date) => Carbon::parse($date))
        ->max();

        /**
         * Reactivation Logic:
         * Cari user (dengan phone yang sama) yang sudah pernah langganan sebelumnya
         * lalu subscribe lagi di rentang ini (start - end)
         */
        $reactivations = 0;

        $groupedByPhone = $allSubs->groupBy('phone');

        foreach ($groupedByPhone as $phone => $subs) {
            if ($subs->count() < 2) continue;

            $subs = $subs->sortBy('created_at')->values();

            for ($i = 1; $i < $subs->count(); $i++) {
                $prev = $subs[$i - 1];
                $curr = $subs[$i];

                $prevEnd = collect($prev->delivery_days)->max();
                $currStart = collect($curr->delivery_days)->min();

                if (
                    $prevEnd && $currStart &&
                    Carbon::parse($prevEnd)->lt(Carbon::parse($currStart)->subDay()) &&
                    Carbon::parse($currStart)->between($start, $end)
                ) {
                    $reactivations++;
                    break;
                }
            }
        }

        // chart
        $activeDates = [];
        $inactiveDates = [];

        foreach ($subscriptions as $sub) {
            $lastDelivery = collect($sub->delivery_days)->max();
            $isActive = $lastDelivery >= now()->toDateString(); // status aktif berdasarkan tanggal terakhir

            foreach ($sub->delivery_days as $day) {
                if ($day >= $start && $day <= $end) {
                    if ($isActive) {
                        $activeDates[] = $day;
                    } else {
                        $inactiveDates[] = $day;
                    }
                }
            }
        }

        $activeCounts = array_count_values($activeDates);
        $inactiveCounts = array_count_values($inactiveDates);

        // Gabungkan semua tanggal unik
        $allDates = array_unique(array_merge(array_keys($activeCounts), array_keys($inactiveCounts)));
        sort($allDates);

        $chartLabels = $allDates;
        $activeChartData = array_map(fn($date) => $activeCounts[$date] ?? 0, $chartLabels);
        $inactiveChartData = array_map(fn($date) => $inactiveCounts[$date] ?? 0, $chartLabels);


        return view('admin.pages.dashboard', compact(
            'subscriptions',
            'newSubscriptions',
            'activeNewSubscriptions',
            'inactiveNewSubscriptions',
            'totalRevenue',
            'reactivations',
            'activeSubscriptions',
            'latestDeliveryDate',
            'start',
            'end',
            'chartLabels',
            'activeChartData',
            'inactiveChartData',
        ));
    }

}
