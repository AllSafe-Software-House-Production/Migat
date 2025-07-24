<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\RequestResource;
use App\Http\Traits\UserResponseTrait;
use Illuminate\Http\Request;
use App\Models\Request as RequestModel;
use Illuminate\Support\Facades\Storage;

class RequestController extends Controller
{
    use UserResponseTrait;
    public function index(Request $request)
    {
        $query = RequestModel::with(['user', 'package'])->latest();

        if ($request->has('type') && in_array($request->type, ['package', 'tour', 'airport_transfer'])) {
            $query->where('type', $request->type);
        }

        $requests = $query->paginate(10);

        return $this->success([
            'requests' => RequestResource::collection($requests),
            'pagination' => [
                'total' => $requests->total(),
                'per_page' => $requests->perPage(),
                'current_page' => $requests->currentPage(),
                'last_page' => $requests->lastPage(),
            ],
        ], 'Requests fetched');
    }


    public function show($id)
    {
        $request = RequestModel::with(['user', 'package'])->find($id);
        if (! $request) return $this->fail('Request not found', 404);

        return $this->success(new RequestResource($request), 'Request found');
    }

    public function destroy($id)
    {
        $request = RequestModel::find($id);
        if (! $request) return $this->fail('Request not found', 404);

        if ($request->passport_file) {
            Storage::disk('public')->delete($request->passport_file);
        }

        $request->delete();
        return $this->success(null, 'Request deleted');
    }
}
