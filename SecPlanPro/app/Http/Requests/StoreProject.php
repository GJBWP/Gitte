<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProject extends FormRequest
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
            'projectname' => 'required',
            'customer_id' => 'required',
            'startdate' => 'required',
            'starttime' => 'required',
            'enddate' => 'required',
            'endtime' => 'required',
            'description' => 'required',
            'clothing' => 'required',
            'address' => 'required',
            'employees' => 'required',
            'hours_per_employee' => 'required',
               ];
    }

    public function messages(){
        return [
            'projectname.required' => "U dient een Projectnaam in te voeren.",
            'customer_id.required' => "U dient een Klant te selecteren.",
            'startdate.required' => "U dient een startdatum in te voeren.",
            'starttime.required' => "U dient een starttijd in te voeren.",
            'enddate.required' => "U dient een einddatum in te voeren.",
            'endtime.required' => "U dient een eindtijd in te voeren.",
            'description.required' => "U dient een omschrijving van de werkzaamheden in te voeren.",
            'clothing.required' => "U dient een omschrijving van de kleding in te voeren.",
            'address.required' => "U dient een adres in te voeren. Indien het project meer dan 1 adres omvat, dan deze bij de taak te specificeren",
            'employees.required' => "U dient het aantal benodigde medewerkers in te voeren.",
            'hours_per_employee.required' => "U dient het totaal aantal uren per medewerker in te voeren.",


        ];
    }
}
