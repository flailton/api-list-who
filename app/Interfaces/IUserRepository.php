<?php

namespace App\Interfaces;

use App\Interfaces\IRepository;

interface IUserRepository extends IRepository
{
    public function all();
    
    public function store(array $attributes);

    public function show(int $id);

    public function update(array $attributes, int $id);

    public function destroy(int $id);
}
