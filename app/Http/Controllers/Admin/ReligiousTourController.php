<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReligiousTourRequest;
use App\Http\Resources\Admin\ReligiousTourResource;
use App\Http\Traits\UserResponseTrait;
use App\Models\ReligiousTour;
use Illuminate\Http\Request;

class ReligiousTourController extends Controller
{
    use UserResponseTrait;
    public function index()
    {
        $tours = ReligiousTour::latest()->paginate(10);
        return $this->success(ReligiousTourResource::collection($tours), 'Tours fetched');
    }

    public function store(ReligiousTourRequest $request)
    {
        $data = $request->validated();

        unset($data['photos']);
        unset($data['image']);

        $tour = ReligiousTour::create($data);

        $image =0;

        if ($request->hasFile('image')) {
            $media =$tour->addMedia($request->file('image'))->toMediaCollection('religious_image');
            $image = $media->id;
        }

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $tour->addMedia($photo)->toMediaCollection('religious_tour');
            }
        }

        $tour->update([
            'image' => $image
        ]);

        return $this->success(new ReligiousTourResource($tour), 'Tour created');
    }

    public function show($id)
    {
        $religiousTour = ReligiousTour::find($id);
        if (! $religiousTour) return $this->fail('Tour not found', 404);
        return $this->success(new ReligiousTourResource($religiousTour), 'Tour fetched');
    }

    public function update(ReligiousTourRequest $request, $id)
    {
        $religiousTour = ReligiousTour::find($id);
        if (! $religiousTour) return $this->fail('Tour not found', 404);

        $data = $request->validated();

        unset($data['photos'], $data['image']);

        $religiousTour->update($data);

        $image = $religiousTour->image;

        if ($request->hasFile('image')) {
            $religiousTour->clearMediaCollection('religious_image');
            $media = $religiousTour->addMedia($request->file('image'))->toMediaCollection('religious_image');
            $image = $media->id;
        }

        if ($request->hasFile('photos')) {
            $religiousTour->clearMediaCollection('photos');
            foreach ($request->file('photos') as $photo) {
                $religiousTour->addMedia($photo)->toMediaCollection('religious_tour');
            }
        }

        $religiousTour->update([
            'image' => $image
        ]);

        return $this->success(new ReligiousTourResource($religiousTour), 'Tour updated');
    }

    public function destroy(ReligiousTour $religiousTour)
    {
        $religiousTour->delete();
        return $this->success(null, 'Tour deleted');
    }
}
