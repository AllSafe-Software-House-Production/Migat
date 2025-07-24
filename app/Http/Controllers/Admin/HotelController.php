<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HotelRequest;
use App\Http\Resources\Admin\HotelResource;
use App\Http\Traits\UserResponseTrait;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    use UserResponseTrait;

    public function index(Request $request)
    {
        $query = Hotel::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('availability')) {
            $query->where('availability', filter_var($request->availability, FILTER_VALIDATE_BOOLEAN));
        }

        $hotels = Hotel::withCount(['rooms as available_rooms_count' => function ($q) {
            $q->available();
        }])
        ->when($request->filled('name'), fn($q) => $q->where('name', 'like', '%' . $request->name . '%'))
        ->when($request->filled('location'), fn($q) => $q->where('location', 'like', '%' . $request->location . '%'))
        ->when($request->filled('availability'), fn($q) => $q->where('availability', filter_var($request->availability, FILTER_VALIDATE_BOOLEAN)))
        ->latest()
        ->paginate(10);
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

    public function store(HotelRequest $request)
    {
        $data = $request->validated();

        $hotel = Hotel::create($data);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $hotel->addMedia($photo)->toMediaCollection('images');
            }
        }

        if ($request->hasFile('utility_bill')) {
            $hotel->addMedia($request->file('utility_bill'))->toMediaCollection('utility_bill');
        }
        return $this->success(new HotelResource($hotel), 'Hotel created');
    }

    public function show($id)
    {
        $hotel = Hotel::find($id);
        if (! $hotel) return $this->fail('Hotel not found', 404);

        return $this->success(new HotelResource($hotel));
    }

    public function update(HotelRequest $request, $id)
    {
        $hotel = Hotel::find($id);
        if (! $hotel) return $this->fail('Hotel not found', 404);

        $hotel->update($request->validated());

        if ($request->hasFile('photos')) {
            $hotel->clearMediaCollection('images');
            foreach ($request->file('photos') as $photo) {
                $hotel->addMedia($photo)->toMediaCollection('images');
            }
        }

        if ($request->hasFile('utility_bill')) {
            $hotel->clearMediaCollection('utility_bill');
            $hotel->addMedia($request->file('utility_bill'))->toMediaCollection('utility_bill');
        }

        return $this->success(new HotelResource($hotel), 'Hotel updated');
    }

    public function destroy($id)
    {
        $hotel = Hotel::find($id);
        if (! $hotel) return $this->fail('Hotel not found', 404);

        $hotel->delete();

        return $this->success(null, 'Hotel deleted');
    }
}
