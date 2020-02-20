<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTask extends FormRequest
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
            'startdate' => 'required',
            'starttime' => 'required',
            'enddate' => 'required',
            'endtime' => 'required',
            'break' => 'required',
        ];
    }
    public function messages(){
        return [

            'startdate.required' => "U dient een startdatum in te voeren.",
            'starttime.required' => "U dient een starttijd in te voeren.",
            'enddate.required' => "U dient een einddatum in te voeren.",
            'endtime.required' => "U dient een eindtijd in te voeren.",
            'break.required' => "U dient de pauze in te voeren.",



        ];
    }
}
