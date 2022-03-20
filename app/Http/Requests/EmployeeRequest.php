<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'full_name'     => 'required',
            'user_name'     => 'required|unique:users',
            'designation'   => 'required',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|min:6',
            'gender'        => 'required|numeric',
        ];
    }
}
