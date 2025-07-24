<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProfileRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name'     => 'sometimes|string|max:255',
            // 'email'    => 'sometimes|email|unique:users,email,' . $this->user()->id,
            'extra_email'  => 'sometimes|nullable|email|max:255',
            'phone'    => 'sometimes|string|unique:users,phone,' . $this->user()->id,
            'photo' => 'nullable|image|max:2048',
            'gender'   => 'sometimes|string',
            'nickname' => 'sometimes|string|max:255',
            'country'  => 'sometimes|string|max:255',
            'language' => 'sometimes|string|max:255',
            'timezone' => 'sometimes|string|max:255',
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
