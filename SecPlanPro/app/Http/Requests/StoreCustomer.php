<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomer extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'companyname' => 'required',
            'companycontact' => 'required',
            'phone' => 'required',
            'email' => 'required',

        ];
    }

    public function messages(){
        return [
            'companyname.required' => 'Vul de Bedrijfsnaam in.',
            'companycontact.required' => 'Vul de naam van de contactpersoon in.',
            'phone.required' => 'Vul het telefoonnummer van de contactpersoon in.',
            'email.required' => 'Vul het e-mail adres van de contactpersoon in.',
        ];
    }
}
