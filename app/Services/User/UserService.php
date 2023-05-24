<?php

namespace App\Services\User;

use App\Repositories\Users\UserRepository;
use Exception;

class UserService
{
    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function store($data)
    {
        return $this->userRepository->create($data);
    }

    public function find($login)
    {
        $user = $this->userRepository->getDataByUser($login);

        if (!$user) {
            throw new Exception('Usuário não encontrado!');
        }

        return $user;
    }

    public function update($data)
    {
        $this->find($data['login']);

        return $this->userRepository->update($data);
    }

    public function delete($login)
    {
        $this->find($login);
        
        $this->userRepository->delete($login);
    }
}