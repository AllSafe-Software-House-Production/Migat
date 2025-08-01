<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RoomRequest extends FormRequest
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
            'hotel_id' => 'required|exists:hotels,id',
            'room_type' => 'required|in:single,double,large',
            'space' => 'nullable|numeric|min:0',
            'number_of_beds' => 'required|integer|min:1',
            'number_of_adults' => 'required|integer|min:1',
            'number_of_children' => 'nullable|integer|min:0',
            'room_photos.*' => 'nullable|image|max:2048',
            'services' => ['nullable', 'array'],
            'services.*' => ['string'],
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
