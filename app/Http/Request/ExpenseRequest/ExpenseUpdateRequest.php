<?php

namespace App\Http\Request\ExpenseRequest;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
   
    public function rules()
    {
        return [
            'status' => 'required|in:aprovado',
            'aprovador_id' => 'required',
            'data_aprovacao' => 'required|date',
            'justification_refused' => 'nullable|string|max:255',
        ];
    }
}