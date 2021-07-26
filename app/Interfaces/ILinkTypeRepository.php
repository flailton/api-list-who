<?php

namespace App\Interfaces;

use App\Interfaces\IRepository;

interface ILinkTypeRepository extends IRepository
{
    public function all();
    
}
