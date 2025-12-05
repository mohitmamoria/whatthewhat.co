<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;

class QotdController extends Controller
{
    public function index()
    {
        return inertia('Qotd/Index');
    }

    public function play()
    {
        $question = Question::forToday();

        return inertia('Qotd/Play', [
            'question' => QuestionResource::make($question),
        ]);
    }

    public function attempt(Request $request)
    {
        $player = auth()->user('player');

        $validated = $request->validate([
            'answer' => 'required|numeric|min:0|max:3',
        ]);

        $question = Question::forToday();

        $attempt = $question->options[$validated['answer']];

        $player->attempts()->create([
            'question_id' => $question->id,
            'answer' => $validated['answer'],
            'is_correct' => $attempt['is_correct'],
            'time_spent' => 11,
        ]);

        return redirect()->back();
    }
}
