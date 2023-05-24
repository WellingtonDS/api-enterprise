<?php

namespace App\Http\Controllers;

use App\Http\Request\UserRequest\UserLoginRequest;
use Illuminate\Http\Response;
use App\Services\User\UserService;
use App\Http\Request\UserRequest\UserStoreRequest;
use App\Http\Request\UserRequest\UserUpdateRequest;

/**
 * valida os dados recebidos no momento da criação e atualização de um usuário, criptografa a senha e o CPF que permite vincular um usuario.
 */
class UserController extends Controller
{   
    public $userService;
    public $userLoginRequest;

    public function __construct(UserService $userService, UserLoginRequest $userLoginRequest)
    {
        $this->userService = $userService;
        $this->userLoginRequest = $userLoginRequest;
    }

    public function store(UserStoreRequest $request)
    {
        $validatedData = $request->validated();
        dd($validatedData);
        
        $user = $this->userService->store($validatedData);
        
        return response()->json($user, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function show(int $login)
    {
        $login = $this->userLoginRequest->ValidateLogin($login);

        $user = $this->userService->find($login);
        //criar resource apos banco de dados

        return response()->json($user ,Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request)
    {
        $validatedData = $request->validated();
        $user = $this->userService->update($validatedData);
        
        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     */
    public function delete(int $login)
    {
        $login = $this->userLoginRequest->ValidateLogin($login);
        
        $this->userService->delete($login);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}