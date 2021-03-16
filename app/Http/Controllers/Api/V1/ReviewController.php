<?php


namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
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

        $reviews = Review::where('book_id', $request->book_id)
                        ->orderBy('updated_at', 'desc')
                        ->get();

        return ReviewResource::collection($reviews);
    }

    public function store(StoreReviewRequest $request)
    {
        auth()->user()->reviews()->create($request->all());
    }

    public function update(UpdateReviewRequest $request, Review $review)
    {
        if($review->user_id != auth()->user()->id){
            abort(404);
        }

        $review->update($request->all());
    }

    public function userReview(Request $request)
    {
        $review = Review::where('book_id', $request->book_id)
                ->where('user_id', auth()->user()->id)
                ->first();
        if(!$review){
            abort('404');
        }

        return new ReviewResource($review);
    }
}
