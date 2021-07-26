<?php

namespace App\Services;

use App\Interfaces\ILinkTypeRepository;
use App\Interfaces\ILinkTypeService;

class LinkTypeService implements ILinkTypeService
{
    private ILinkTypeRepository $linktypeRepository;

    public function __construct(
        ILinkTypeRepository $linktypeRepository
    ) {
        $this->linktypeRepository = $linktypeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Array
     */
    public function all()
    {
        $linktypes = $this->linktypeRepository->all();

        return $linktypes;
    }
}
