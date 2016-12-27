<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class CreateBulkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //No auth needed to make request
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
            'price' => 'required', //Queries the database to get the max number of availbility for the specific room
            'availability' => 'required|digits_between:1,3|max:5',
            'start_date' => 'required|date|date_format:Y-m-d|before:end_date',
            'end_date' => 'required|date|date_format:Y-m-d|after:start_date',
            'roomtype_id' => 'required',
            'days' => 'required'
        ];
    }

    //Error messages which will be sent to the view
    public function messages()
    {
        return [
            'price.required' => 'You need to enter a price',
            'availability.required' => 'You need to enter the availability',
            'availability.digits_between' => 'Maximum two digits for availability',
            'availability.max' => 'You entered an invalid number of availability',
            'start_date.required' => 'You need to enter a start date',
            'start_date.date_format' => 'You need to enter the date in the following format: yyyy-mm-dd',
            'start_date.before:end_date' => 'The start date must be before end date',
            'end_date.required' => 'You need to enter an end date',
            'end_date.date_format' => 'You need to enter the date in the following format: yyyy-mm-dd',
            'end_date.after:start_date' => 'The end date must be after start date',
            'days.required' => 'You must choose what days you want to update'
        ];
    }
}
