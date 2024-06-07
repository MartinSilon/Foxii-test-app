<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'is_registered' => 'sometimes|boolean',
            'registration_number' => 'nullable|numeric|unique:cars,registration_number'
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
            'registration_number.unique' => "Registračné číslo už je viazané na iné vozidlo.",
            'registration_number.required' => "Pri registrovanom vozidle je nutné vyplniť aj registračné čislo.",
        ];
    }
}
