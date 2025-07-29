<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class HotelRequest extends FormRequest
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
        return $this->isMethod('post') ? $this->store() : $this->update();
    }

    

    private function store()
    {
        return [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'availability' => 'boolean',
            'description' => 'nullable|string',
            'distance_from_haram' => 'nullable|string',
            'special_check_in_instructions' => 'nullable|string',
            'access_methods' => 'nullable|string',
            'pets' => 'nullable|string',
            'commission' => 'nullable|numeric|min:0|max:100',
            'commercial_register' => 'nullable|string',
            'tourism_license' => 'nullable|string',
            'utility_bill' => 'nullable|image|max:2048',
            'owner_id' => 'required|exists:users,id',
            'ipan' => 'nullable|string',
            'visa' => 'nullable|string',
            'number_of_rooms' => 'required|integer|min:1',
            'phone' => 'required|string',
            'email' => 'required|email',
            // 'service_ids' => 'nullable|array',
            // 'service_ids.*' => 'exists:services,id',
            // 'policy_ids' => 'nullable|array',
            // 'policy_ids.*' => 'exists:policies,id',
            'hotel_link' => 'nullable|url|max:255',
            'policy' => 'nullable|string',
            'service' => 'nullable|string',
            'photos.*' => 'nullable|image|max:2048',
        ];
    }

    private function update()
    {
        return $this->store();
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
