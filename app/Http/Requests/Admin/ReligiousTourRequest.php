<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException; 

class ReligiousTourRequest extends FormRequest
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
            'share_tour' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|max:2048',
            'phone' => 'required|string',
            'email' => 'required|email',
            'whatsapp' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'what_will_you_do' => 'required|string',
            'photos.*' => 'nullable|image|max:2048',
        ];
    }

    private function update()
    {
        return [
            'share_tour' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'sometimes|image|max:2048',
            'phone' => 'sometimes|string',
            'email' => 'sometimes|email',
            'whatsapp' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'what_will_you_do' => 'sometimes|string',
            'photos.*' => 'sometimes|image|max:2048',
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
