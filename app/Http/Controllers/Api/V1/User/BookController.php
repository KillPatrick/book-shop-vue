<?php


namespace App\Http\Controllers\Api\V1\User;

use App\Http\Requests\StoreBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController
{
    public function index(Request $request)
    {
        $books = Book::when(isset($request->search), function ($query) use ($request){
                            $query->where('title', 'like', '%'.$request->search.'%');
                        })
                    ->whereNUll('is_approved')
                    ->with('genres')
                    ->with('authors')
                    ->orderBy('created_at', 'desc')
                    ->paginate(18);

        return BookResource::collection($books);
    }

    public function show(Book $book)
    {
        if($book->is_approved){
            return new BookResource($book);
        }
        abort(404);
    }
    public function store(StoreBookRequest $request)
    {
        $book = Book::createBookWithAuthorsGenres($request);
        $book->save();
    }

    public function update(StoreBookRequest $request, Book $book)
    {
        if($book->user_id != auth()->user()->id){
            abort(404);
        }
        $book->title = $request->title;
        $book->description = $request->description;
        $book->price = $request->price;
        $book->discount = $request->discount;
        $book->genres()->sync($request->genres);
        $book->is_approved = null;
        $authors = preg_split("/\,/", $request->authors, NULL, PREG_SPLIT_NO_EMPTY);
        $syncAuthors = [];
        foreach ($authors as $authorName) {
            $author = Author::updateOrCreate(['name' => trim($authorName)]);
            $syncAuthors[] = $author->id;
        }
        $book->authors()->sync($syncAuthors);
        $book->save();
    }

    public function checkOwner($book_id)
    {
        $book = Book::find($book_id);
        if($book->user_id === auth()->user()->id){
            return true;
        }
        abort(404);
    }
}
