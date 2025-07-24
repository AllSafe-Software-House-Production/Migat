<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoomRequest;
use App\Http\Resources\Admin\RoomResource;
use App\Models\Room;
use App\Http\Traits\UserResponseTrait;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    use UserResponseTrait;

    public function index(Request $request)
    {
        $query = Room::with('hotel');

        if ($request->filled('hotel_id')) {
            $query->where('hotel_id', $request->hotel_id);
        }

        $rooms = $query->latest()->paginate(10);

        return $this->success([
            'rooms' => RoomResource::collection($rooms),
            'pagination' => [
                'total' => $rooms->total(),
                'per_page' => $rooms->perPage(),
                'current_page' => $rooms->currentPage(),
                'last_page' => $rooms->lastPage(),
            ]
        ], 'Rooms fetched');
    }


    public function store(RoomRequest $request)
    {
        $room = Room::create($request->validated());

        if ($request->hasFile('room_photos')) {
            foreach ($request->file('room_photos') as $photo) {
                $room->addMedia($photo)->toMediaCollection('room_photos');
            }
        }

        return $this->success(new RoomResource($room), 'Room created');
    }

    public function show($id)
    {
        $room = Room::find($id);
        if (! $room) return $this->fail('Room not found', 404);

        return $this->success(new RoomResource($room));
    }

    public function update(RoomRequest $request, $id)
    {
        $room = Room::find($id);
        if (! $room) return $this->fail('Room not found', 404);

        $room->update($request->validated());

        if ($request->hasFile('room_photos')) {
            $room->clearMediaCollection('room_photos');
            foreach ($request->file('room_photos') as $photo) {
                $room->addMedia($photo)->toMediaCollection('room_photos');
            }
        }

        return $this->success(new RoomResource($room), 'Room updated');
    }

    public function destroy($id)
    {
        $room = Room::find($id);
        if (! $room) return $this->fail('Room not found', 404);

        $room->delete();

        return $this->success(null, 'Room deleted');
    }
}
