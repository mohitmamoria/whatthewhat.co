<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlayerResource;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\WalletResource;
use App\Models\Player;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $player = $request->user('player');

        $wallet = $player?->wallet;

        // get paginated transactions for this player with eager loaded activity for each transaction
        $transactions = $player?->transactions()->with('activity')->paginate(20);

        return inertia('Game/Index', [
            'wallet' => $wallet ? WalletResource::make($wallet) : null,
            'transactions' => $transactions ? inertia()->scroll(TransactionResource::collection($transactions)) : null,
        ]);
    }
}
