<?php

namespace App\Http\Request\ExpenseRequest;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
   
    public function rules()
    {
        return [
            'user_id' => 'required',
            'company_id' => 'required',
            'value' => 'required',
            'status' => 'required',
            'approved' => 'required',
            'date_approved' => 'required',
            'justification_refused' => 'nullable',
        ];
    }
}