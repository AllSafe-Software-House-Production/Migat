<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\AirportTransferRequest;
use App\Http\Traits\UserResponseTrait;

class RequestController extends Controller
{
    use UserResponseTrait;

    public function storeAirportTransfer(AirportTransferRequest $request)
    {
        $user = $request->user();

        $data = $request->validated();
        $data['type'] = 'airport_transfer';
        $data['user_id'] = $user->id;

        $airportTransferRequest = Request::create($data);

        return $this->success([
            'request' => $airportTransferRequest
        ], 'Airport transfer request submitted successfully.');
    }
}
