<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
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
            'full_name'                 => 'required',
            'user_name'                 => 'required|unique:users',
            'designation'               => 'required|numeric',
            'email'                     => 'required|email|unique:users',
            'password'                  => 'required|min:6',
            'gender'                    => 'required|numeric',
            'department'             => 'required|numeric',
            'educational_qualification' => 'required|numeric',
            'medical_degree'            => 'required|numeric',
            'speciality'                => 'required',
            'payment_receiving_process' => 'required|numeric',
        ];
    }
}
