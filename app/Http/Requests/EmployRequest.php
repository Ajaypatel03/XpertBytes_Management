<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'mobile_no' => 'required|string|max:10',
            'email' => 'required|string|email|max:255',
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
        ];
    }
}