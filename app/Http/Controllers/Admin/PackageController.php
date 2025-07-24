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
        $package = Package::create($request->validated());
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $package->addMedia($image)->toMediaCollection('packages');
            }
        }
        return $this->success(new PackageResource($package), 'Package created');
    }

    public function show($id)
    {
        $package = Package::find($id);
        if (! $package) return $this->fail('Package not found', 404);
        return $this->success(new PackageResource($package), 'Package fetched');
    }

    public function update(PackageRequest $request, Package $package)
    {
        $package->update($request->validated());
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $package->addMedia($image)->toMediaCollection('images');
            }
        }
        return $this->success(new PackageResource($package), 'Package updated');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return $this->success([], 'Package deleted');
    }
}
