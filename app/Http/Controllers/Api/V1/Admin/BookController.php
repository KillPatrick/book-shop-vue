<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Services\ImageService;
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

    public function update(StoreBookRequest $request, Book $book)
    {
        $book->title = $request->title;
        $book->description = $request->description;
        $book->price = $request->price;
        $book->discount = $request->discount;
        $book->genres()->sync($request->genres);
        $book->is_approved = 1;
        $authors = preg_split("/\,/", $request->authors, NULL, PREG_SPLIT_NO_EMPTY);

        $syncAuthors = [];
        foreach ($authors as $authorName) {
            $author = Author::updateOrCreate(['name' => trim($authorName)]);
            $syncAuthors[] = $author->id;
        }

        $book->authors()->sync($syncAuthors);
        $book->save();
    }
}
