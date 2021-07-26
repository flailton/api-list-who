<?php

namespace App\Services;

use App\Interfaces\ILinkRepository;
use App\Interfaces\ILinkService;
use Exception;

class LinkService implements ILinkService
{
    private ILinkRepository $linkRepository;

    public function __construct(
        ILinkRepository $linkRepository
    ) {
        $this->linkRepository = $linkRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Array  $data
     * @return Array
     */
    public function store(Array $data)
    {
        $link = $this->linkRepository->store($data);

        return $link;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Array  $data
     * @return Array
     */
    public function update(Array $data, int $id)
    {
        if (empty($this->linkRepository->show($id))) {
            throw new Exception('Link do contato informado não existe!');
        }

        if (empty($link = $this->linkRepository->update($data, $id))) {
            throw new Exception('Falha ao atualizar o link do contato!');
        }

        return $link;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Array
     */
    public function destroy(int $id)
    {
        if (empty($this->linkRepository->show($id))) {
            throw new Exception('Link do contato informado não existe!');
        }

        return $this->linkRepository->destroy($id);
    }
}
