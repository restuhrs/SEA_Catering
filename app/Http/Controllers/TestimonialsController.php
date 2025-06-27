<?php

namespace App\Http\Controllers;

use App\Models\Testimonials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialsController extends Controller
{
    public function index ()
    {
        $testimoni = [
            [
                'name' => 'Shey',
                'rating' => 5,
                'message' => 'The meals are incredibly fresh and delicious! I feel healthier every day.',
                'photo' => Storage::url('assets/images/testimoni1.jpg'),
            ],
            [
                'name' => 'Jerome',
                'rating' => 5,
                'message' => 'Perfect for my busy schedule. Nutritious and tasty!',
                'photo' => Storage::url('assets/images/testimoni2.jpg'),
            ],
            [
                'name' => 'Putri',
                'rating' => 5,
                'message' => 'Great service and amazing healthy food. Highly recommended!',
                'photo' => Storage::url('assets/images/testimoni3.jpg'),
            ],
        ];

        return view('pages.testimonials', compact('testimoni'));
    }

    public function store (Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'review' => 'required|string|max:200',
            'rating' => 'required|in:1,2,3,4,5',
        ]);

        Testimonials::create($validated);

        return redirect()->to(url()->previous() . '#feedback-form')->with('success', 'Thank you for your feedback!');
    }
}
