<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarRequest extends FormRequest
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
            'is_registered' => 'sometimes|boolean',
            'registration_number' => 'nullable|numeric'
        ];
    }


    protected function withValidator($validator)
    {
        $validator->sometimes('registration_number', 'required', function ($input) {
            return $input->is_registered == 1;
        });
    }


    public function messages()
    {
        return[
            'name.required' => "Prosím, vyplňte meno vozidla.",
            'registration_number.numeric' => "Pri registrovanom vozidle je nutné vyplniť aj registračné čislo.",
            'registration_number.required' => "Pri registrovanom vozidle je nutné vyplniť aj registračné čislo.",
        ];
    }
}
