<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PackageRequest extends FormRequest
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
            'price' => 'required|numeric|min:0',
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
            'transportation' => 'required|string|max:255',
            'trip_type' => 'required|string|max:255',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'travel_company' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:1000',
            'type' => 'sometimes|string|max:255',

            'no_of_days' => 'sometimes|integer|min:1',
            'hotel_location' => 'sometimes|string|max:255',
            'hotel_name' => 'sometimes|string|max:255',
            'room_type' => 'sometimes|string|max:255',
            'services' => 'sometimes|array',
            'services.*' => 'string|max:255',
            'hotel_price' => 'sometimes|numeric|min:0',
            'hotel_trip_type' => 'sometimes|string|max:255',
            'hotel_from' => 'sometimes|date',
            'hotel_to' => 'sometimes|date|after_or_equal:hotel_from',
            'hotel_type' => 'sometimes|string|max:255', // Makah or Madinah
            'hotel_images.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'short_video' => 'sometimes|file|mimes:mp4,avi,mov,wmv|max:10240',
        ];
    }

    private function update()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0',
            'from' => 'sometimes|date',
            'to' => 'sometimes|date|after_or_equal:from',
            'transportation' => 'sometimes|string|max:255',
            'images.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'trip_type' => 'sometimes|string|max:255',
            'travel_company' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:1000',
            'type' => 'sometimes|string|max:255',

            'no_of_days' => 'sometimes|integer|min:1',
            'hotel_location' => 'sometimes|string|max:255',
            'hotel_name' => 'sometimes|string|max:255',
            'room_type' => 'sometimes|string|max:255',
            'services' => 'sometimes|array',
            'services.*' => 'string|max:255',
            'hotel_price' => 'sometimes|numeric|min:0',
            'hotel_trip_type' => 'sometimes|string|max:255',
            'hotel_from' => 'sometimes|date',
            'hotel_to' => 'sometimes|date|after_or_equal:hotel_from',
            'hotel_type' => 'sometimes|string|max:255', // Makah or Madinah
            'hotel_images.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'short_video' => 'sometimes|file|mimes:mp4,avi,mov,wmv|max:10240',
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
