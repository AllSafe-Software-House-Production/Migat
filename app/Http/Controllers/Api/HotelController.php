<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\HotelResource;
use App\Http\Resources\Admin\ReviewResource;
use App\Http\Traits\UserResponseTrait;
use App\Models\Hotel;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    use UserResponseTrait;

    public function index(Request $request)
    {
        $query = Hotel::query();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('city')) {
            $query->where('location', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('min_price')) {
            $query->whereHas('rooms', function ($q) use ($request) {
                $q->where('price', '>=', $request->min_price);
            });
        }

        if ($request->filled('max_price')) {
            $query->whereHas('rooms', function ($q) use ($request) {
                $q->where('price', '<=', $request->max_price);
            });
        }

        if ($request->filled('services')) {
            $query->whereJsonContains('service_ids', $request->services);
        }

        if ($request->filled('distance')) {
            $query->where('distance_from_haram', '<=', $request->distance);
        }

        if ($request->filled('room_type')) {
            $query->whereHas('rooms', function ($q) use ($request) {
                $q->where('type', $request->room_type);
            });
        }

        $hotels = $query->latest()->paginate(10);

        return $this->success([
            'hotels' => HotelResource::collection($hotels),
            'pagination' => [
                'total' => $hotels->total(),
                'per_page' => $hotels->perPage(),
                'current_page' => $hotels->currentPage(),
                'last_page' => $hotels->lastPage(),
            ]
        ], 'Hotels fetched');
    }

    public function services()
    {
        $services = Service::all();

        return $this->success([
            'services' => $services,
        ], 'Services fetched');
    }

    public function hotelReviews($hotelId)
    {
        $reviews = Review::where('hotel_id', $hotelId)->latest()->paginate(10);

        return $this->success([
            'reviews' => ReviewResource::collection($reviews),
            'pagination' => [
                'total' => $reviews->total(),
                'per_page' => $reviews->perPage(),
                'current_page' => $reviews->currentPage(),
                'last_page' => $reviews->lastPage(),
            ]
        ], 'Hotel reviews fetched');
    }


}
