<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHour extends FormRequest
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
            'workedstartdate' => 'required',
            'workedstarttime' => 'required',
            'workedenddate' => 'required',
            'workedendtime' => 'required',
            'workedbreak' => 'required',
        ];
    }
    public function messages(){
        return [

            'workedstartdate.required' => "U dient een startdatum in te voeren.",
            'workedstarttime.required' => "U dient een starttijd in te voeren.",
            'workedenddate.required' => "U dient een einddatum in te voeren.",
            'workedendtime.required' => "U dient een eindtijd in te voeren.",
            'workedbreak.required' => "U dient de pauze in te voeren.",



        ];
    }
}
