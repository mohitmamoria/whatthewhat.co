<?php

namespace App\Http\Controllers\QR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComingSoonController extends Controller
{
    public function show(Request $request)
    {
        $intended = $request->input('page');

        return inertia('QR/ComingSoon', [
            'intended' => $intended,
        ]);
    }

    public function subscribe(Request $request)
    {
        $player = $request->user('player');
        $page = $request->input('page');

        $player->comingSoonSubscriptions()->create([
            'page' => $page,
        ]);

        return redirect()->back();
    }
}
