<?php

namespace App\Http\Controllers\Markbook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReadingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:markbook_books,id',
            'pages_read' => 'required|integer|min:1|max:1000',
            'notes' => 'required|string|max:1000',
        ]);

        auth('player')->user()->readings()->create([
            'book_id' => $validated['book_id'],
            'pages_read' => $validated['pages_read'],
            'notes' => $validated['notes'],
        ]);

        return redirect()->back();
    }
}
