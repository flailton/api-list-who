<?php

namespace App\Services;

use App\Interfaces\IPhoneTypeRepository;
use App\Interfaces\IPhoneTypeService;

class PhoneTypeService implements IPhoneTypeService
{
    private IPhoneTypeRepository $phonetypeRepository;

    public function __construct(
        IPhoneTypeRepository $phonetypeRepository
    ) {
        $this->phonetypeRepository = $phonetypeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Array
     */
    public function all()
    {
        $phonetypes = $this->phonetypeRepository->all();

        return $phonetypes;
    }
}
