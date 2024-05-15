<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DebitRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date' => 'required|date',
            'board_members_id' => 'required|string|max:255',
            'amount' => 'required|string|max:255',
            'remark' => 'required|string|max:255',
        ];
    }
}