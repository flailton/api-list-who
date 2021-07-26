<?php

namespace App\Interfaces;

use App\Interfaces\IRepository;

interface IPhoneTypeRepository extends IRepository
{
    public function all();
    
}
