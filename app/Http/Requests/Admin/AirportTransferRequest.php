<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AirportTransferRequest extends FormRequest
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
            'driver_name' => 'required|string|max:255',
            'car_plate_number' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:20',
            'type_of_car' => 'required|string|max:255',
        ];
    }

    private function update(): array
    {
        return [
            'driver_name' => 'sometimes|string|max:255',
            'car_plate_number' => 'sometimes|string|max:255',
            'whatsapp_number' => 'sometimes|string|max:20',
            'type_of_car' => 'sometimes|string|max:255',
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
