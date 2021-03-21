<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Http\Resources\Json\JsonResource;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::when(isset($request->search), function ($query) use ($request){
                    $query->where('title', 'like', '%'.$request->search.'%');
                })
                ->with('genres')
                ->with('authors')
                ->orderBy('created_at', 'desc')
                ->paginate(18);

        return BookResource::collection($books);
    }

    public function show(Book $book)
    {
        return new BookResource($book);
    }

    public function store(StoreBookRequest $request)
    {
        $book = Book::createBookWithAuthorsGenres($request);

        $book->is_approved = 1;

        $book->save();
    }
}
