<?php

namespace App\Repositories;

use App\Models\PhoneType;
use App\Interfaces\IPhoneTypeRepository;

class PhoneTypeRepository implements IPhoneTypeRepository
{
    private PhoneType $phonetype;

    public function __construct(PhoneType $phonetype) {
        $this->phonetype = $phonetype;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->phonetype->all();
    }
}