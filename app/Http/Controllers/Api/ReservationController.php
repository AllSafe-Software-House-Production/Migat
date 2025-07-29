<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Http\Traits\UserResponseTrait;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    use UserResponseTrait;

    public function index(Request $request)
    {
        $user = $request->user();

        $reservations = Reservation::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return $this->success([
            'reservations' => ReservationResource::collection($reservations),
            'pagination' => [
                'total' => $reservations->total(),
                'per_page' => $reservations->perPage(),
                'current_page' => $reservations->currentPage(),
                'last_page' => $reservations->lastPage(),
            ]
        ], 'User reservations fetched successfully');
    }
    public function store(StoreReservationRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();
        $data['user_id'] = $user?->id;

        $reservation = Reservation::create($data);

        if ($request->hasFile('id_file')) {
            $reservation->addMediaFromRequest('id_file')->toMediaCollection('id_documents');
        }

        if ($request->hasFile('passport_file')) {
            $reservation->addMediaFromRequest('passport_file')->toMediaCollection('passport_documents');
        }

        return $this->success(
            new ReservationResource($reservation),
            'Reservation submitted successfully'
        );
    }

}
