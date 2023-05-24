<?php

namespace App\Http\Request\UserRequest;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
   
    public function rules()
    {
        return [
            'login' => 'int|required',
            'email' => 'sometimes|email',
            'password' => 'sometimes|min:8',
            'company_id' => 'sometimes'
        ];
    }
}