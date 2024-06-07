<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'serialNumber' => 'required',
            'car_id' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Prosím, vyplňte názov dielu.",
            'serialNumber.required' => "Prosím, vyplňte seriové číslo dielu.",
        ];
    }
}
