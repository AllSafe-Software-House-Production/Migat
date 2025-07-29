<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PackageRequest;
use App\Http\Resources\Admin\PackageResource;
use App\Http\Traits\UserResponseTrait;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    use UserResponseTrait;

    public function index(Request $request)
    {
        $query = Package::query();

        if ($request->has('id')) {
            $query->where('id', $request->id);
        }

        $packages = $query->latest()->paginate(10);

        return $this->success([
            'packages' => PackageResource::collection($packages),
            'pagination' => [
                'total' => $packages->total(),
                'per_page' => $packages->perPage(),
                'current_page' => $packages->currentPage(),
                'last_page' => $packages->lastPage(),
            ]
        ], 'Packages fetched');
    }


    public function storePackage(PackageRequest $request)
    {
        $user = $request->user();

        $data = $request->only([
            'full_name',
            'passport_number',
            'phone',
            'room_type',
            'no_of_people'
        ]);
        $data['type'] = 'package';
        $data['user_id'] = $user->id;

        $packageRequest = Request::create($data);

        if ($request->hasFile('photo')) {
            $packageRequest->addMediaFromRequest('photo')->toMediaCollection('photo');
        }

        if ($request->hasFile('passport')) {
            $packageRequest->addMediaFromRequest('passport')->toMediaCollection('passport');
        }

        return $this->success([
            'request' => $packageRequest
        ], 'Package request submitted successfully.');
    }

}
