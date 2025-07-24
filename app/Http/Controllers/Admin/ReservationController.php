<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReservationRequest;
use App\Http\Resources\Admin\ReservationResource;
use App\Models\Reservation;
use App\Http\Traits\UserResponseTrait;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    use UserResponseTrait;

    public function index(Request $request)
    {
        $reservations = Reservation::with(['user', 'room'])->latest()->paginate(10);

        return $this->success([
            'reservations' => ReservationResource::collection($reservations),
            'pagination' => [
                'total' => $reservations->total(),
                'per_page' => $reservations->perPage(),
                'current_page' => $reservations->currentPage(),
                'last_page' => $reservations->lastPage(),
            ]
        ], 'Reservations fetched');
    }

    public function store(ReservationRequest $request)
    {
        $validated = $request->validated();

        $conflict = Reservation::where('room_id', $validated['room_id'])
            ->where('status', 'confirmed')
            ->where(function ($query) use ($validated) {
                $query->whereDate('check_in', '<', $validated['check_out'])
                    ->whereDate('check_out', '>', $validated['check_in']);
            })
            ->exists();

        if ($conflict) {
            return $this->fail('This room is already reserved in the selected period.', 409);
        }

        $reservation = Reservation::create($validated);

        return $this->success(
            new ReservationResource($reservation->load('user', 'room')),
            'Reservation created'
        );
    }


    public function show($id)
    {
        $reservation = Reservation::with(['user', 'room'])->find($id);
        if (! $reservation) return $this->fail('Reservation not found', 404);

        return $this->success(new ReservationResource($reservation));
    }

    public function update(ReservationRequest $request, $id)
    {
        $reservation = Reservation::find($id);
        if (! $reservation) return $this->fail('Reservation not found', 404);

        $reservation->update($request->validated());

        return $this->success(new ReservationResource($reservation->load('user', 'room')), 'Reservation updated');
    }

    public function destroy($id)
    {
        $reservation = Reservation::find($id);
        if (! $reservation) return $this->fail('Reservation not found', 404);

        $reservation->delete();

        return $this->success(null, 'Reservation deleted');
    }
}
