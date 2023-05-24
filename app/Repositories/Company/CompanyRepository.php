<?php

namespace App\Repositories\Company;

use App\Models\Company;

class CompanyRepository
{
        protected $model;
        
        public function __construct(Company $model)
        {
                $this->model = $model;
        }
        
        public function find($id)
        {
                return $this->model->find($id);
        }

        public function create($data)
        {
                return $this->model->create([
                        'cnpj' => bcrypt($data['cnpj']),
                        'nome_fantasia' => $data['nome_fantasia'],
                        'razao_social' => $data['razao_social'],
                ]);
        }
        
        public function getDataByCompany($data)
        {
                return $this->model->find($data);
        }

        public function update($data)
        {
                return $this->model->fill($data)->save();
        }

        public function delete($data)
        {
                return $this->model->find($data)->delete();
        }
}