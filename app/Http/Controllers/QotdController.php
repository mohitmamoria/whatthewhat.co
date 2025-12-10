<?php

namespace App\Http\Controllers;

use App\Actions\Qotd\PatchQotdStats;
use App\Actions\Qotd\UpdateQotdStats;
use App\Http\Resources\AttemptResource;
use App\Http\Resources\PlayerResource;
use App\Http\Resources\QotdGameResource;
use App\Http\Resources\QuestionResource;
use App\Models\Attempt;
use App\Models\Gamification\ActivityType;
use App\Models\Player;
use App\Models\QotdGame;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QotdController extends Controller
{
    public function index(Request $request)
    {
        $question = Question::forToday();

        $player = $request->user('player');
        $game = $player?->qotd;
        $referrer = $request->query('ref')
            ? Player::byReferrerCode($request->query('ref'))
            : null;

        return inertia('Qotd/Index', [
            'question' => QuestionResource::make($question),
            'referrer' => $referrer ? PlayerResource::make($referrer) : null,
            'qotd_game' => $game ? QotdGameResource::make($game) : null,
        ]);
    }

    public function stats(Request $request)
    {
        $player = $request->user('player');
        $game = $player?->qotd;

        if (is_null($game)) {
            return redirect()->route('qotd.index');
        }

        return inertia('Qotd/Stats', [
            'qotd_game' => QotdGameResource::make($game),
        ]);
    }

    public function join(Request $request)
    {
        $player = $request->user('player');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ref'  => 'nullable|string|max:50',
        ]);

        $referrer = $validated['ref']
            ? Player::byReferrerCode($validated['ref'])
            : null;

        DB::transaction(function () use ($player, $referrer, $validated) {
            $player->update([
                'name' => $validated['name'],
            ]);

            $player->qotd()->firstOrCreate([
                'joined_on' => now()->toDateString(),
                'expires_on' => now()->addDays(QotdGame::DEFAULT_EXPIRES_DAYS)->toDateString(),
                'referrer_id' => $referrer?->id,
            ]);

            $player->acted(ActivityType::QOTD_JOINED);

            if ($referrer) {
                $referrer->acted(ActivityType::QOTD_REFERRED, ['referred_player_id' => $player->id]);

                $referrer->qotd->recalculateExpiry();
            }
        });


        return redirect()->back();
    }

    public function attempt(Request $request, Question $question)
    {
        $player = auth()->user('player');

        $attempt = DB::transaction(function () use ($player, $question) {
            $existing = $player->attempts()->where('question_id', $question->id)->first();
            if ($existing) {
                return $existing;
            }

            $attempt = $player->attempts()->create([
                'question_id' => $question->id,
            ]);

            (new PatchQotdStats)($player, $attempt);

            $player->acted(ActivityType::QOTD_ATTEMPTED, ['question_id' => $question->id]);

            return $attempt;
        });

        return redirect()->route('qotd.play', ['attempt' => $attempt->name]);
    }

    public function play(Request $request, Attempt $attempt)
    {
        $player = auth()->user('player');

        if ($player->id !== $attempt->player_id) {
            abort(403);
        }

        $attempt->load('question');

        return inertia('Qotd/Play', [
            'attempt' => AttemptResource::make($attempt),
        ]);
    }

    public function answer(Request $request, Attempt $attempt)
    {
        $player = auth()->user('player');

        if ($player->id !== $attempt->player_id) {
            abort(403);
        }

        $validated = $request->validate([
            'answer' => 'required|numeric|min:0|max:3',
            'time_left' => 'required|numeric|max:' . Attempt::TIME_PER_ATTEMPT,
        ]);

        $chosenOption = $attempt->question->options[$validated['answer']];

        DB::transaction(function () use ($player, $attempt, $chosenOption, $validated) {
            // Only if NOT already attempted or NOT timed out!
            if ($attempt->time_spent === null) {
                $attempt->update([
                    'answer' => $validated['answer'],
                    'is_correct' => $chosenOption['is_correct'],
                    'time_spent' => Attempt::TIME_PER_ATTEMPT - $validated['time_left'],
                ]);

                (new PatchQotdStats)($player, $attempt);
            }

            if ($chosenOption['is_correct']) {
                $player->acted(ActivityType::QOTD_ANSWERED, ['question_id' => $attempt->question_id]);
            }
        });

        return redirect()->back();
    }

    public function timeout(Request $request, Attempt $attempt)
    {
        $player = auth()->user('player');

        if ($player->id !== $attempt->player_id) {
            abort(403);
        }

        DB::transaction(function () use ($player, $attempt) {
            // Only if NOT already attempted or NOT timed out!
            if ($attempt->time_spent === null) {
                $attempt->update([
                    'answer' => Attempt::TIMEOUT_ANSWER,
                    'is_correct' => false,
                    'time_spent' => Attempt::TIME_PER_ATTEMPT,
                ]);

                (new PatchQotdStats)($player, $attempt);
            }
        });

        return redirect()->back();
    }
}
