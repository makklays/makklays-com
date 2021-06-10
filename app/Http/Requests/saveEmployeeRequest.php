<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class saveEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'lastname' => 'required|min:3|max:255',
            'firstname' => 'required|min:3|max:255',
            'post' => 'required',
            'company_id' => 'required|integer',
            'phone' => 'required'
        ];
    }
}
