<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubscriptionController extends Controller
{
    public function create(Request $request)
    {
        $deliveryDates = [];

        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->addDays($i);
            $deliveryDates[] = [
                'day' => $date->format('l'),        // Monday
                'date' => $date->format('d M'),     // 24 Jun
                'full' => $date->format('Y-m-d'),   // 2025-06-24
            ];
        }

        // Ambil subscription terbaru user by phone number
        $subscriptions = Subscription::where('phone', Auth::user()->phone)
        ->latest()
        ->take(5)
        ->get();

        $user = Auth::user(); // ambil user login

        return view('pages.subscription', compact('deliveryDates', 'subscriptions', 'user'));
    }

    public function getStatusAttribute($delivery_days)
    {
        $latestDate = collect($delivery_days)->max();

        if (!$latestDate) return 'inactive';

        return Carbon::parse($latestDate)->isPast() ? 'inactive' : 'active';
    }

    public function store(Request $request)
    {
        // Tangkap nilai checkbox "Subscribe for 1 Week"
        $oneWeek = $request->has('subscribe_for_week');

        $delivery_days = $request->input('delivery_days', []);

        if ($oneWeek) {
            $delivery_days = [];
            for ($i = 0; $i < 7; $i++) {
                $delivery_days[] = now()->addDays($i)->toDateString();
            }
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'plan' => 'required|string',
            'meal_types' => 'required|array',
            'delivery_days' => 'required|array',
            'allergies' => 'nullable|string|max:200',
            'total_price' => 'required|numeric',
        ]);

        $subscription = Subscription::create(array_merge(
            $validated,
            [
                'full_name' => Auth::user()->name,
                'phone' => Auth::user()->phone,
                'delivery_days' => $delivery_days,
                'expired_at' => collect($delivery_days)->max(),
            ]
        ));

        // Generate PDF Invoice
        $pdf = Pdf::loadView('pdf.invoice', ['subscription' => $subscription]);

        // Nama file
        $filename = 'invoice_' . $subscription->id . '.pdf';

        // Path simpan relatif (dalam Laravel storage disk 'public')
        $relativePath = 'invoices/' . $filename;

        // Simpan PDF ke storage/app/public/invoices
        Storage::disk('public')->put($relativePath, $pdf->output());

        // Ambil path absolut dari file yang sudah disimpan
        $absolutePath = storage_path('app/public/' . $relativePath);

        // Download file
        return response()->download($absolutePath);

        // return back()->with('success', 'Subscription saved successfully!');
    }

}
