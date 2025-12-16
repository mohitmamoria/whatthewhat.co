<?php

namespace App\Http\Controllers;

use App\Http\Resources\TotemResource;
use App\Models\Totem;
use Illuminate\Http\Request;

class TotemController extends Controller
{
    public function index(Request $request)
    {
        $player = $request->user('player');

        // return all totems with progress for this player
        $totems = Totem::with('players')
            ->whereHas('players', function ($query) use ($player) {
                $query->where('player_id', $player->id);
            })
            ->orWhereDoesntHave('players', function ($query) use ($player) {
                $query->where('player_id', $player->id);
            })
            ->get();

        return inertia('Totems/Index', [
            'totems' => TotemResource::collection($totems),
        ]);
    }
}
