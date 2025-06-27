<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'full_name',
        'phone',
        'plan',
        'meal_types',
        'delivery_days',
        'allergies',
        'total_price',
    ];

    protected $casts = [
        'meal_types' => 'array',
        'delivery_days' => 'array',
    ];

    protected $appends = ['status', 'active_until']; // agar bisa dipanggil sebagai $subscription->status

    protected function status(): Attribute
    {
        return Attribute::make(
            get: function () {
                $lastDate = collect($this->delivery_days)->max();
                if (!$lastDate) return 'inactive';
                return Carbon::parse($lastDate)->endOfDay()->isPast() ? 'inactive' : 'active';
            }
        );
    }

    protected function activeUntil(): Attribute
    {
        return Attribute::make(
            get: fn () => collect($this->delivery_days)->max()
                ? Carbon::parse(collect($this->delivery_days)->max())->format('d-m-Y')
                : null
        );
    }

}
