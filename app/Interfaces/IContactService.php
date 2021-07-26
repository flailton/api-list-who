<?php


namespace App\Interfaces;

use App\Interfaces\IService;

interface IContactService extends IService
{
    public function all();
    
    public function store(array $attributes);

    public function show(int $id);

    public function update(array $attributes, int $id);

    public function destroy(int $id);
}
