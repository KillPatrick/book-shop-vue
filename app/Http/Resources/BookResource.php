<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($request->has('editing')){
            return [
                'id' => $this->id,
                'title' => $this->title,
                'description' => $this->when($request->book, $this->description),
                'price' => $this->price,
                'discount' => $this->discount,
                'genres' => $this->genres->pluck('id'),
                'authors' => $this->authors->pluck('name')->implode(', '),
                'user_id' => $this->user_id
            ];
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->when($request->book, $this->description),
            'image' => $this->imagePath,
            'price' => $this->price,
            'discounted_price' => $this->discountedPrice(),
            'discount' => $this->discount,
            'genres' => $this->genres->pluck('name')->implode(', '),
            'authors' => $this->authors->pluck('name')->implode(', '),
            'rating' => $this->reviewsRating(),
            'new' => $this->new(),
            'is_approved' => $this->is_approved,
            'user_id' => $this->user_id
        ];
    }
}
