<?php

namespace App\Http\Requests;

use App\Models\Activity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActivityReservationRequest extends FormRequest
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
            'number_people' => ['required','integer'],
        ];
    }

    public function messages()
    {
        return [
            'number_people.required' => __("valdiation.required"),
        ];
    }
}
