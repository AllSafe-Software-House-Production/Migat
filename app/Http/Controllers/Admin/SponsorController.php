<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SponsorRequest;
use App\Http\Resources\Admin\SponsorResource;
use App\Http\Traits\UserResponseTrait;
use App\Models\Sponsor;
use Illuminate\Support\Facades\Storage;


class SponsorController extends Controller
{
    use UserResponseTrait;

    public function index()
    {
        $sponsers = Sponsor::latest()->paginate(10);
        return $this->success([
            'events' => SponsorResource::collection($sponsers),
            'pagination' => [
                'total' => $sponsers->total(),
                'per_page' => $sponsers->perPage(),
                'current_page' => $sponsers->currentPage(),
                'last_page' => $sponsers->lastPage(),
            ]
        ], 'Sponsors fetched');
    }

    public function store(SponsorRequest $request)
    {
        $data = $request->validated();
        $sponser = Sponsor::create($data);
        if ($request->hasFile('photo')) {
                $sponser->addMedia($request->file('photo'))->toMediaCollection('sponsors');

        }
        return $this->success(new SponsorResource($sponser), 'Sponsor created');
    }

    public function update(SponsorRequest $request, $id)
    {
        $sponser = Sponsor::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $sponser->clearMediaCollection('photo');
            $sponser->addMedia($request->file('photo'))->toMediaCollection('sponsors');
        }

        $sponser->update($data);
        return $this->success(new SponsorResource($sponser), 'Sponsor updated');
    }

    public function show($id)
    {
        $sponser = Sponsor::findOrFail($id);
        return $this->success(new SponsorResource($sponser), 'Sponsor fetched');
    }

    public function destroy($id)
    {
        $sponser = Sponsor::findOrFail($id);
        if (! $sponser) return $this->fail('Sponsor not found', 404);
   
        $sponser->delete();
        return $this->success(null, 'Sponsor deleted');
    }

}
