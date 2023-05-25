<?php

namespace App\Http\Request\CompanyRequest;

use Illuminate\Foundation\Http\FormRequest;

class CompanyStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
   
    public function rules()
    {
        return [
            'cnpj' => 'required',
            'name_fantasia' => 'required',
            'razao_social' => 'required',
        ];
    }
}