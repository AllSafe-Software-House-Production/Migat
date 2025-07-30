<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Http\Traits\UserResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use UserResponseTrait;

    public function index(Request $request)
    {
        $query = User::query()
            ->where('role', '!=', 'superAdmin')
            ->latest();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $users = $query->paginate(10);

        return $this->success([
            'users' => UserResource::collection($users),
            'pagination' => [
                'total' => $users->total(),
                'per_page' => $users->perPage(),
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
            ]
        ], 'Users fetched successfully');
    }


    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());
        return $this->success(new UserResource($user), 'User created successfully');
    }

    public function show($id)
    {
        $user = User::find($id);
        if (! $user) return $this->fail('User not found', 404);
        return $this->success(new UserResource($user));
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);
        if (! $user) return $this->fail('User not found', 404);
        $user->update($request->validated());
        return $this->success(new UserResource($user), 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (! $user) return $this->fail('User not found', 404);
        $user->delete();
        return $this->success(null, 'User deleted successfully');
    }
}