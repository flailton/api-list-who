<?php

namespace App\Services;

use App\Interfaces\IPhoneRepository;
use App\Interfaces\IPhoneService;
use Exception;

class PhoneService implements IPhoneService
{
    private IPhoneRepository $phoneRepository;

    public function __construct(
        IPhoneRepository $phoneRepository
    ) {
        $this->phoneRepository = $phoneRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Array  $data
     * @return Array
     */
    public function store(Array $data)
    {
        $phone = $this->phoneRepository->store($data);

        return $phone;
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
        if (empty($this->phoneRepository->show($id))) {
            throw new Exception('Telefone do contato informado não existe!');
        }

        if (empty($phone = $this->phoneRepository->update($attributes, $id))) {
            throw new Exception('Falha ao atualizar o telefone do contato!');
        }

        return $phone;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Array
     */
    public function destroy(int $id)
    {
        if (empty($this->phoneRepository->show($id))) {
            throw new Exception('Telefone do contato informado não existe!');
        }

        return $this->phoneRepository->destroy($id);
    }
}
