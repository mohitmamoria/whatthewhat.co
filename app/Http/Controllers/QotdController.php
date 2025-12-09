<?php

namespace App\Http\Controllers;

use App\Actions\Qotd\UpdateQotdStats;
use App\Http\Resources\AttemptResource;
use App\Http\Resources\QotdGameResource;
use App\Http\Resources\QuestionResource;
use App\Models\Attempt;
use App\Models\Gamification\ActivityType;
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

        return inertia('Qotd/Index', [
            'question' => QuestionResource::make($question),
            'qotd_game' => $game ? QotdGameResource::make($game) : null,
        ]);
    }

    public function join(Request $request)
    {
        $player = $request->user('player');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($player, $validated) {
            $player->update([
                'name' => $validated['name'],
            ]);

            $player->qotd()->firstOrCreate([
                'joined_on' => now()->toDateString(),
                'expires_on' => now()->addDays(QotdGame::DEFAULT_EXPIRES_DAYS)->toDateString(),
            ]);

            $player->acted(ActivityType::QOTD_JOINED);
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
        ]);

        $chosenOption = $attempt->question->options[$validated['answer']];

        DB::transaction(function () use ($player, $attempt, $chosenOption, $validated) {
            // Only if NOT already attempted or NOT timed out!
            if ($attempt->time_spent === null) {
                $attempt->update([
                    'answer' => $validated['answer'],
                    'is_correct' => $chosenOption['is_correct'],
                    'time_spent' => $attempt->created_at->diffInSeconds(now()),
                ]);
            }

            if ($chosenOption['is_correct']) {
                $player->acted(ActivityType::QOTD_ANSWERED, ['question_id' => $attempt->question_id]);
            }

            (new UpdateQotdStats)($player);
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
                    'time_spent' => $attempt->created_at->diffInSeconds(now()),
                ]);
            }

            (new UpdateQotdStats)($player);
        });

        return redirect()->back();
    }
}
