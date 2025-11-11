<?php

namespace App\Http\Controllers\Markbook;

use App\Http\Controllers\Controller;
use App\Http\Resources\Markbook\BookResource;
use App\Models\Markbook\Book;
use Illuminate\Http\Request;

class BookSearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $limit = min((int) $request->query('limit', 10), 50);

        if ($q === '' || mb_strlen($q) < 2) {
            $books = collect();
        } else {
            $books = BookResource::collection(
                Book::whereLike('title', '%' . $q . '%')
                    ->orWhereLike('authors', '%' . $q . '%')
                    ->limit($limit)
                    ->get()
            );
        }
        return response()->json([
            'data' => $books,
        ]);
    }
}
