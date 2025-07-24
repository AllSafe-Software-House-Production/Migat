<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReviewRequest;
use App\Http\Resources\Admin\ReviewResource;
use App\Http\Traits\UserResponseTrait;
use App\Models\Review;

class ReviewController extends Controller
{
    use UserResponseTrait;

    public function index()
    {
        $reviews = Review::latest()->paginate(10);
        return $this->success([
            'reviews' => ReviewResource::collection($reviews),
            'pagination' => [
                'total' => $reviews->total(),
                'per_page' => $reviews->perPage(),
                'current_page' => $reviews->currentPage(),
                'last_page' => $reviews->lastPage(),
            ]
        ], 'Reviews fetched');
    }

    public function store(ReviewRequest $request)
    {
        $review = Review::create($request->validated());
        if ($request->hasFile('image')) {
            $review->addMedia($request->file('image'))->toMediaCollection('review_image');
        }

        return $this->success(new ReviewResource($review), 'Review created');
    }

    public function show($id)
    {
        $review = Review::findOrFail($id);
        return $this->success(new ReviewResource($review), 'Review fetched');
    }

    public function update(ReviewRequest $request, $id)
    {
        $review = Review::findOrFail($id);
        $review->update($request->validated());

        if ($request->hasFile('image')) {
            $review->clearMediaCollection('review_image');
            $review->addMedia($request->file('image'))->toMediaCollection('review_image');
        }

        return $this->success(new ReviewResource($review), 'Review updated');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return $this->success(null, 'Review deleted');
    }
}

