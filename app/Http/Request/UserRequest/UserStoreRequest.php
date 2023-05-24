<?php

namespace App\Http\Request\UserRequest;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
   
    public function rules()
    {
        return [
            'email' => 'required|email',
            'login' => 'integer|required',
            'password' => 'required|min:8',
            'cpf' => 'required',
            'company_id' => 'required'
        ];
    }
}