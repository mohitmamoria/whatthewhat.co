<?php

namespace App\Actions\Qotd;

use App\Models\Player;

class GetReferralMessage
{
    public function __invoke(Player $player): string
    {
        $url = route('qotd.index', ['ref' => $player->referrer_code]);

        return <<<EOT
Hey! I play the Question Of The Day (QOTD) to keep my curiosity alive! I think you'll love it too. You get one question every day to answer and earn points.

You too can play QOTD (free!) here:

{$url}
EOT;
    }
}
