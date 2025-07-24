<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class TourRequest extends FormRequest
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
            'pickup_location' => 'required|string|max:255',
            'no_of_members' => 'required|integer|min:1',
            'transfer_date' => 'required|date',
            'transfer_time' => 'required|date_format:H:i',
            'transportation' => 'required|string|max:100',
            'religious_guide' => 'required|boolean',
            'tour_type' => 'required|in:group,solo',
        ];
    }
}
