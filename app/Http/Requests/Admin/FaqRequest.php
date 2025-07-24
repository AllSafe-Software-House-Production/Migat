<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FaqRequest extends FormRequest
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
            'question' => 'required|string|max:255',
            'response' => 'required|string',
            'location' => 'nullable|string',
            'date' => 'nullable|date',
        ];
    }

    private function update(): array {
        return [
            'question' => 'sometimes|string|max:255',
            'response' => 'sometimes|string',
            'location' => 'sometimes|nullable|string',
            'date' => 'sometimes|nullable|date',
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
