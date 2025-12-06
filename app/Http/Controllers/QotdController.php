<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttemptResource;
use App\Http\Resources\QuestionResource;
use App\Models\Attempt;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QotdController extends Controller
{
    public function index()
    {
        $question = Question::forToday();

        return inertia('Qotd/Index', [
            'question' => QuestionResource::make($question),
        ]);
    }

    public function attempt(Request $request, Question $question)
    {
        $player = auth()->user('player');

        $attempt = DB::transaction(function () use ($player, $question) {
            $existing = $player->attempts()->where('question_id', $question->id)->first();
            if ($existing) {
                return $existing;
            }

            return $player->attempts()->create([
                'question_id' => $question->id,
            ]);
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

        $attempted = $attempt->question->options[$validated['answer']];

        // Only if NOT already attempted or NOT timed out!
        if ($attempt->time_spent === null) {
            $attempt->update([
                'answer' => $validated['answer'],
                'is_correct' => $attempted['is_correct'],
                'time_spent' => $attempt->created_at->diffInSeconds(now()),
            ]);
        }

        return redirect()->back();
    }

    public function timeout(Request $request, Attempt $attempt)
    {
        $player = auth()->user('player');

        if ($player->id !== $attempt->player_id) {
            abort(403);
        }

        $attempt->update([
            'answer' => '[[TIMEOUT]]',
            'is_correct' => false,
            'time_spent' => $attempt->created_at->diffInSeconds(now()),
        ]);

        return redirect()->back();
    }
}
