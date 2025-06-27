<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MealPlanController extends Controller
{

    public function index()
    {
        $today = Carbon::today();
        $startDate = Carbon::parse('last Monday')->subWeeks(1);
        $weeks = [];

        for ($i = 0; $i < 6; $i++) {
            $start = $startDate->copy()->addWeeks($i);
            $end = $start->copy()->addDays(6);
            $isActive = $today->between($start, $end);
            $weeks[] = [
                'display' => $start->format('M') !== $end->format('M') ? $start->format('M') . '-' . $end->format('M') : $start->format('M'),
                'dates' => $start->format('d') . '-' . $end->format('d'),
                'active' => $isActive,
            ];
        }

        $mealPlans = [
            [
                'name' => 'Diet Plan',
                'price' => 30000,
                'description' => 'Ideal for those who want to maintain or lose weight. This plan offers calorie-controlled meals with balanced nutrition, perfect for a healthy lifestyle.',
                'image' => Storage::url('assets/images/sayur3.jpg'),
                'type' => 'Breakfast, Lunch, Dinner',
                'delivery' => 'Monday - Sunday Available',
                'tag' => 'Most Order',
                'nutrition' => [
                    'Calories' => '500 kcal',
                    'Protein' => '35g',
                    'Carbs' => '45g',
                    'Fat' => '15g',
                ],
                'ingredients' => 'Chicken breast, broccoli, brown rice, olive oil',
            ],
            [
                'name' => 'Protein Plan',
                'price' => 40000,
                'description' => 'Specially crafted for active individuals and fitness enthusiasts. High in protein and essential nutrients to support muscle growth and recovery.',
                'image' => Storage::url('assets/images/sayur2.jpg'),
                'type' => 'Breakfast, Lunch, Dinner',
                'delivery' => 'Monday - Sunday Available',
                'nutrition' => [
                    'Calories' => '500 kcal',
                    'Protein' => '35g',
                    'Carbs' => '45g',
                    'Fat' => '15g',
                ],
                'ingredients' => 'Chicken breast, broccoli, brown rice, olive oil',
            ],
            [
                'name' => 'Royal Plan',
                'price' => 60000,
                'description' => 'A premium selection of meals made with high-quality ingredients and diverse menus. Designed for customers who want the best in both taste and health.',
                'image' => Storage::url('assets/images/sayur.jpg'),
                'type' => 'Breakfast, Lunch, Dinner',
                'delivery' => 'Monday - Sunday Available',
                'nutrition' => [
                    'Calories' => '500 kcal',
                    'Protein' => '35g',
                    'Carbs' => '45g',
                    'Fat' => '15g',
                ],
                'ingredients' => 'Chicken breast, broccoli, brown rice, olive oil',
            ],
        ];

        return view('pages.meal-plans', compact('mealPlans', 'weeks'));
    }

}
