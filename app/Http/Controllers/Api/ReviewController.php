<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReviewRequest;
use App\Http\Resources\Admin\ReviewResource;
use App\Http\Traits\UserResponseTrait;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use UserResponseTrait;

    public function index()
    {
        $reviews = Review::whereNull('hotel_id')->latest()->paginate(10);

        return $this->success([
            'reviews' => ReviewResource::collection($reviews),
            'pagination' => [
                'total' => $reviews->total(),
                'per_page' => $reviews->perPage(),
                'current_page' => $reviews->currentPage(),
                'last_page' => $reviews->lastPage(),
            ]
        ], 'Global reviews fetched');
    }

    public function store(ReviewRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $review = Review::create($data);

        if ($request->hasFile('image')) {
            $review->addMedia($request->file('image'))->toMediaCollection('review_image');
        }

        return $this->success(new ReviewResource($review), 'Review submitted successfully');
    }
}
