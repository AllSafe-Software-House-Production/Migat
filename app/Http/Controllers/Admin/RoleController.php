<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Http\Resources\Admin\RoleResource;
use App\Http\Traits\UserResponseTrait;

class RoleController extends Controller
{
    use UserResponseTrait;

    public function index()
    {
        $roles = Role::latest()->paginate(10);
        return $this->success([
            'roles' => RoleResource::collection($roles),
            'pagination' => [
                'total' => $roles->total(),
                'per_page' => $roles->perPage(),
                'current_page' => $roles->currentPage(),
                'last_page' => $roles->lastPage(),
            ]
        ], 'Roles fetched');
    }

    public function store(RoleRequest $request)
    {
        $role = Role::create($request->validated());
        return $this->success(new RoleResource($role), 'Role created');
    }

    public function show(Role $role)
    {
        return $this->success(new RoleResource($role), 'Role details');
    }

    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        return $this->success(new RoleResource($role), 'Role updated');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return $this->success(null, 'Role deleted');
    }
}
