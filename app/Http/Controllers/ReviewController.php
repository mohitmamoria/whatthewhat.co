<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function create(Request $request)
    {
        $player = $request->user('player');

        $review = $player?->review;

        return inertia('Reviews/Create', [
            'review' => ReviewResource::make($review),
        ]);
    }

    public function store(Request $request)
    {
        $player = $request->user('player');
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'body' => 'nullable|string',
        ]);

        DB::transaction(function () use ($player, $validated) {
            // If the player already has a review, delete it (soft delete)
            $player->review()->delete();

            $review = $player->review()->create([
                'rating' => $validated['rating'],
                'title' => $validated['title'],
                'body' => $validated['body'],
            ]);
        });

        return redirect()->back();
    }
}
