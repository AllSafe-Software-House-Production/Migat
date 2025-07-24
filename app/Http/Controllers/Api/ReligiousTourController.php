<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TourRequest;
use Illuminate\Http\Request;
use App\Http\Resources\ReligiousTourResource;
use App\Http\Traits\UserResponseTrait;
use App\Models\ReligiousTour;

class ReligiousTourController extends Controller
{
    use UserResponseTrait;

    public function index(Request $request)
    {
        $query = ReligiousTour::query();

        if ($request->has('id')) {
            $query->where('id', $request->id);
        }

        $tours = $query->latest()->paginate(10);

        return $this->success([
            'tours' => ReligiousTourResource::collection($tours),
            'pagination' => [
                'total' => $tours->total(),
                'per_page' => $tours->perPage(),
                'current_page' => $tours->currentPage(),
                'last_page' => $tours->lastPage(),
            ]
        ], 'Tours fetched successfully.');
    }

    public function storeTour(TourRequest $request)
    {
        $user = $request->user();

        $data = $request->validated();
        $data['type'] = 'tour';
        $data['user_id'] = $user->id;

        $tourRequest = Request::create($data);

        return $this->success([
            'request' => $tourRequest
        ], 'Tour request submitted successfully.');
    }
}
