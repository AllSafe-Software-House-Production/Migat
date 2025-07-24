<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RuleRequest;
use App\Http\Resources\Admin\RuleResource;
use App\Http\Traits\UserResponseTrait;

class RuleController extends Controller
{
    use UserResponseTrait;

    public function index()
    {
        $rules = Rule::latest()->paginate(10);
        return $this->success([
            'rules' => RuleResource::collection($rules),
            'pagination' => [
                'total' => $rules->total(),
                'per_page' => $rules->perPage(),
                'current_page' => $rules->currentPage(),
                'last_page' => $rules->lastPage(),
            ]
        ], 'Rules fetched');
    }

    public function store(RuleRequest $request)
    {
        $rule = Rule::create($request->validated());
        return $this->success(new RuleResource($rule), 'Rule created');
    }

    public function show(Rule $rule)
    {
        return $this->success(new RuleResource($rule), 'Rule details');
    }

    public function update(RuleRequest $request, Rule $rule)
    {
        $rule->update($request->validated());
        return $this->success(new RuleResource($rule), 'Rule updated');
    }

    public function destroy(Rule $rule)
    {
        $rule->delete();
        return $this->success(null, 'Rule deleted');
    }
}
