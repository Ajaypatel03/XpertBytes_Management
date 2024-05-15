<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalaryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date' => 'required|date',
            'employ_id' => 'required|string|max:255',
            'salary' => 'required|string|max:255',
            'remark' => 'required|string|max:255',
        ];
    }
}