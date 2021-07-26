<?php

namespace App\Services;

use App\Interfaces\IUserRepository;
use App\Interfaces\IUserService;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserService implements IUserService
{
    private IUserRepository $userRepository;

    public function __construct(
        IUserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Array
     */
    public function all()
    {
        $users = $this->userRepository->all();

        return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Array  $data
     * @return Array
     */
    public function store(Array $data)
    {
        $attributes = $data;
        $attributes['password'] = Hash::make($attributes['password']);
        $user = $this->userRepository->store($attributes);

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Array
     */
    public function show(int $id)
    {
        if (empty($user = $this->userRepository->show($id))) {
            throw new Exception('Usuário informado não existe!');
        }

        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Array  $data
     * @return Array
     */
    public function update(Array $data, int $id)
    {
        $attributes = $data;
        if (empty($this->userRepository->show($id))) {
            throw new Exception('Usuário informado não existe!');
        }

        if (!empty($attributes['password'])) {
            $attributes['password'] = Hash::make($attributes['password']);
        }

        if (empty($user = $this->userRepository->update($attributes, $id))) {
            throw new Exception('Falha ao atualizar o usuário!');
        }

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Array
     */
    public function destroy(int $id)
    {
        if (empty($this->userRepository->show($id))) {
            throw new Exception('Usuário informado não existe!');
        }

        return $this->userRepository->destroy($id);
    }
}
