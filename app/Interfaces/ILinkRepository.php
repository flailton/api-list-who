<?php

namespace App\Interfaces;

use App\Interfaces\IRepository;

interface ILinkRepository extends IRepository
{    
    public function store(array $attributes);

    public function show(int $id);

    public function update(array $attributes, int $id);

    public function destroy(int $id);
}
