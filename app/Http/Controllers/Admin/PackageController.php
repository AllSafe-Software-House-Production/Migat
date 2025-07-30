<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PackageRequest;
use App\Http\Resources\Admin\PackageResource;
use App\Models\Package;
use App\Http\Traits\UserResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    use UserResponseTrait;

    public function index(Request $request)
    {
        $query = Package::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('trip_type')) {
            $query->where('trip_type', $request->trip_type);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('date')) {
            $query->whereDate('from', '<=', $request->date)
                ->whereDate('to', '>=', $request->date);
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


    public function store(PackageRequest $request)
    {
        $data = $request->validated();
        unset($data['images']);
        unset($data['hotel_images']);
        unset($data['short_videos']);

        $package = Package::create($data);

        $imageIds = [];
        $hotelImageIds = [];
        $shortvideosId = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $media = $package->addMedia($image)->toMediaCollection('packages');
                $imageIds[] = $media->id;
            }
        }

        if ($request->hasFile('hotel_images')) {
            foreach ($request->file('hotel_images') as $image) {
                $media = $package->addMedia($image)->toMediaCollection('hotel_images');
                $hotelImageIds[] = $media->id;
            }
        }

        if ($request->hasFile('short_videos')) {
            foreach ($request->file('short_videos') as $video) {
                $media = $package->addMedia($video)->toMediaCollection('short_videos');
                $shortvideosId[] = $media->id;
            }
        }

        $package->update([
            'images' => $imageIds,
            'hotel_images' => $hotelImageIds,
            'short_videos' => $shortvideosId,
        ]);

        return $this->success(new PackageResource($package), 'Package created');
    }


    public function show($id)
    {
        $package = Package::find($id);
        if (! $package) return $this->fail('Package not found', 404);
        return $this->success(new PackageResource($package), 'Package fetched');
    }

    public function update(PackageRequest $request, $id)
    {
        $data = $request->validated();

        $package = Package::find($id);
        if (! $package) return $this->fail('Package not found', 404);

        unset($data['images']);

        $package->update($data);

        $imageIds = $package->images ?? [];
        $hotelImageIds = $package->hotel_images ?? [];
        $shortvideosId = $package->short_videos ?? [];

        if ($request->hasFile('images')) {
            $package->clearMediaCollection('packages');

            $imageIds = [];
            foreach ($request->file('images') as $image) {
                $media = $package->addMedia($image)->toMediaCollection('packages');
                $imageIds[] = $media->id;
            }

            $package->update([
                'images' => $imageIds,
            ]);
        }

        if ($request->hasFile('hotel_images')) {
            $package->clearMediaCollection('hotel_images');

            $hotelImageIds = [];
            foreach ($request->file('hotel_images') as $image) {
                $media = $package->addMedia($image)->toMediaCollection('hotel_images');
                $hotelImageIds[] = $media->id;
            }

            $package->update([
                'hotel_images' => $hotelImageIds,
            ]);
        }

        if ($request->hasFile('short_videos')) {
            $package->clearMediaCollection('short_videos');

            $shortvideosId = [];
            foreach ($request->file('short_videos') as $video) {
                $media = $package->addMedia($video)->toMediaCollection('short_videos');
                $shortvideosId[] = $media->id;
            }

            $package->update([
                'short_videos' => $shortvideosId,
            ]);
        }

        return $this->success(new PackageResource($package), 'Package updated');
    }


    public function destroy(Package $package)
    {
        $package->delete();
        return $this->success([], 'Package deleted');
    }
}
