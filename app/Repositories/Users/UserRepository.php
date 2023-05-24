<?php

namespace App\Repositories\Users;

use App\Models\Users;

class UserRepository
{
    protected $model;
    
    public function __construct(Users $model)
    {
        $this->model = $model;
    }

    public function create($data)
    {
        return $this->model->create([
            'email' => $data['email'],
            'login' => $data['login'],
            'password' => bcrypt($data['password']),
            'cpf' => bcrypt($data['cpf']),
            'company_id' => $data['company_id'],
        ]);
    }
    
    public function getDataByUser($login)
    {
        return $this->model->find($login);
    }

    public function update($data)
    {
        return $this->model->fill($data)->save();
    }

    public function delete($login)
    {
        $this->model->find($login)->delete();
    }
}