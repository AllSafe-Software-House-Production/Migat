<?php

namespace App\Http\Controllers\Admin;

use App\Models\AirportTransfer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AirportTransferRequest;
use App\Http\Resources\Admin\AirportTransferResource;
use App\Http\Traits\UserResponseTrait;

class AirportTransferController extends Controller
{
    use UserResponseTrait;

    public function index(Request $request)
    {
        $query = AirportTransfer::query();

        if ($request->filled('driver_name')) {
            $query->where('driver_name', 'like', '%' . $request->driver_name . '%');
        }

        if ($request->filled('type_of_car')) {
            $query->where('type_of_car', 'like', '%' . $request->type_of_car . '%');
        }

        $transfers = $query->latest()->paginate(10);

        return $this->success([
            'transfers' => AirportTransferResource::collection($transfers),
            'pagination' => [
                'total' => $transfers->total(),
                'per_page' => $transfers->perPage(),
                'current_page' => $transfers->currentPage(),
                'last_page' => $transfers->lastPage(),
            ]
        ], 'Airport transfers fetched');
    }

    public function store(AirportTransferRequest $request)
    {
        $transfer = AirportTransfer::create($request->validated());
        return $this->success(new AirportTransferResource($transfer), 'Airport transfer created');
    }

    public function show($id)
    {
        $transfer = AirportTransfer::find($id);
        if (! $transfer) return $this->fail('Not found', 404);
        return $this->success(new AirportTransferResource($transfer), 'Airport transfer details');
    }

    public function update(AirportTransferRequest $request, $id)
    {
        $transfer = AirportTransfer::find($id);
        if (! $transfer) return $this->fail('Not found', 404);

        $transfer->update($request->validated());
        return $this->success(new AirportTransferResource($transfer), 'Airport transfer updated');
    }

    public function destroy($id)
    {
        $transfer = AirportTransfer::find($id);
        if (! $transfer) return $this->fail('Not found', 404);

        $transfer->delete();
        return $this->success(null, 'Airport transfer deleted');
    }
}