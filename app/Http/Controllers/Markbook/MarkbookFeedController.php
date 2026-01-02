<?php

namespace App\Http\Controllers\Markbook;

use App\Actions\Markbook\CalculateMarkbookStats;
use App\Http\Controllers\Controller;
use App\Http\Resources\Markbook\BookResource;
use App\Http\Resources\Markbook\ReadingResource;
use App\Models\Markbook\Book;
use Illuminate\Http\Request;

class MarkbookFeedController extends Controller
{
    public function index(Request $request)
    {
        $player = $request->user('player');

        $stats = (new CalculateMarkbookStats)($player);

        $lastReading = $player->readings()->latest()->first();

        $readings = $player->readings()->latest()->paginate(20);

        return inertia('Markbook/Feed', [
            'stats' => $stats,
            'readings' => inertia()->scroll(ReadingResource::collection($readings)),
        ]);
    }
}
