<?php

namespace App\Http\Controllers;

use App\Http\Request\CompanyRequest\CompanyDataRequest;
use App\Http\Request\CompanyRequest\CompanyStoreRequest;
use App\Http\Request\CompanyRequest\CompanyUpdateRequest;
use App\Services\Company\CompanyService;
use \Illuminate\Http\Response;

/**
 * valida os dados recebidos no momento da criação e atualização de uma Company, criptografa o CNPJ e retorna o CNPJ descriptografado na exibição.
 */

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $companyService;
    public $companyDataRequest;

    public function __construct(CompanyService $companyService, CompanyDataRequest $companyDataRequest)
    {
        $this->companyService = $companyService;
    }

    public function store(CompanyStoreRequest $request)
    {
        $validatedData = $request->validated();
        dd($validatedData);
    
        $company = $this->companyService->store($validatedData);
    
        return response()->json($company, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $company
     * @return \Illuminate\Http\Response
     */
    public function show(int $company)
    {
        $company = $this->companyDataRequest->validateData($company);
        $user = $this->companyService->find($company)
        ;
        return response()->json($company, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyUpdateRequest $request)
    {
        $validatedData = $request->validated();
        $company = $this->companyService->update($validatedData);

        return response()->json($company, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $company
     * @return \Illuminate\Http\Response
     */
    public function delete($company)
    {
        $company = $this->companyDataRequest->ValidateLogin($company);
        
        $this->companyService->delete($company);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
