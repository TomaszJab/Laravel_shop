<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonalDetailsRequest extends FormRequest
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
        if ($this->has('personal_details') && is_array($this->input('personal_details'))) {
            $this->merge($this->input('personal_details'));
        }

        $companyOrPrivatePerson = $this->input('company_or_private_person');

        $rules = [
            'email' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'phone' => 'required',

            'street' => 'required',
            'house_number' => 'required',
            'zip_code' => 'required',
            'city' => 'required',

        ];

        if ($companyOrPrivatePerson == 'company') { //'private_person'
            $rules['company_name'] = 'required';
            $rules['nip'] = 'required';
        }

        $rules['acceptance_of_the_regulations'] = 'sometimes|required|accepted';

        return $rules;
    }
}
