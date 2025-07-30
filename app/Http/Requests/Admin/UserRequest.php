<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return $this->isMethod('post') ? $this->store() : $this->update();
    }

    private function store(): array {
        return [
            'name'         => ['required', 'string', 'max:255'],
            'phone'        => ['required', 'string', 'max:20', 'unique:users,phone'],
            'email'        => ['required', 'email', 'unique:users,email'],
            'password'     => ['required', 'string', 'min:6'],
            'role'         => ['nullable', 'string','in:user,admin'],
            'gender'       => ['nullable', 'in:male,female'],
            'nickname'     => ['nullable', 'string'],
            'country'      => ['nullable', 'string'],
            'language'     => ['nullable', 'string'],
            'timezone'     => ['nullable', 'string'],
            'extra_email'  => ['nullable', 'email'],
            'rule_id'      => ['nullable', 'exists:rules,id'],
        ];
    }

    private function update(): array {
        return [
            'name'         => ['required', 'string', 'max:255'],
            'phone'        => ['required', 'string', 'max:20'],
            'email'        => ['required', 'email'],
            'role'         => ['nullable', 'string','in:user,admin'],
            'gender'       => ['nullable', 'in:male,female'],
            'nickname'     => ['nullable', 'string'],
            'country'      => ['nullable', 'string'],
            'language'     => ['nullable', 'string'],
            'timezone'     => ['nullable', 'string'],
            'extra_email'  => ['nullable', 'email'],
            'rule_id'      => ['nullable', 'exists:rules,id'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422));
    }
}
