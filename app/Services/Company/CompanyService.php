<?php

namespace App\Services\Company;

use App\Repositories\Company\CompanyRepository;
use Exception;

class CompanyService
{
    public $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function store($data)
    {
        return $this->companyRepository->create($data);
    }

    public function find($data)
    {
        $company = $this->companyRepository->getDataByCompany($data);
        if (!$company) {
            throw new Exception('Empresa não encontrada!');
        }
    }

    public function update($data)
    {
        $this->find($data['cnpj']);

        return $this->companyRepository->update($data);
    }

    public function delete($data)
    {
        $this->find($data);

        $this->companyRepository->delete($data);
    }
}