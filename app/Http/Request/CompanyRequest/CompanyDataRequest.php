<?php

namespace App\Http\Request\CompanyRequest;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\Exceptions\ValidationErrorException;


class CompanyDataRequest
{   
    public function ValidateData($company)
    {
        $validator = Validator::make(
            [
                'cnpj' => $company
            ],
            [
                'cnpj' => 'required|int'
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