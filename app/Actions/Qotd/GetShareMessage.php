<?php

namespace App\Actions\Qotd;

use App\Models\Attempt;
use App\Models\Player;
use Illuminate\Support\Str;

class GetShareMessage
{
    public function __invoke(Attempt $attempt): string
    {
        $player = $attempt->player;
        $url = 'https://wtw.is/qotd?' . http_build_query(['ref' => $player->referrer_code]);
        $title = $attempt->question->title;
        $action = $attempt->is_correct ? 'Answered' : 'Played';
        $timeUnit = Str::plural('second', $attempt->time_spent);

        return <<<EOT
QOTD ({$title})

{$action} in: ⚡️ {$attempt->time_spent} {$timeUnit} ⚡️

Play today's QOTD here:
{$url}
EOT;
    }
}
