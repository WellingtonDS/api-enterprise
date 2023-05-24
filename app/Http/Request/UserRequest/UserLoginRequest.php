<?php

namespace App\Http\Request\UserRequest;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationErrorException;

class UserLoginRequest
{   
    public function ValidateLogin($login)
    {
        $validator = Validator::make(
            [
                'login' => $login
            ],
            [
                'login' => 'required|int'
            ]
        );

        if ($validator->fails()) {
            throw new ValidationErrorException(
                message: json_encode($validator->errors()->getMessages()),
                code: Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return $validator->validated();
    }
}