<?php


namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;


class ReviewController
{
    public function index(Request $request)
    {
        if(!$request->book_id){
            abort('404');
        }

        $reviews = Review::where('book_id', $request->book_id)->get();

        return ReviewResource::collection($reviews);
    }

    public function userReview(Request $request)
    {
        $review = Review::where('book_id', $request->book_id)
                ->where('user_id', auth()->user()->id)
                ->first();

        return new ReviewResource($review);
    }
}
