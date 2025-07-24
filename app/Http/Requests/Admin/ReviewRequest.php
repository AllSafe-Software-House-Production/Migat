<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReviewRequest extends FormRequest
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

    private function store(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'hotel_id' => 'nullable|exists:hotels,id',
            'review' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ];
    }

    private function update(): array
    {
        return [
            'user_id' => 'sometimes|exists:users,id',
            'hotel_id' => 'nullable|exists:hotels,id',
            'review' => 'sometimes|string',
            'image' => 'nullable|image|max:2048',
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
