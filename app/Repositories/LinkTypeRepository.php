<?php

namespace App\Repositories;

use App\Models\LinkType;
use App\Interfaces\ILinkTypeRepository;

class LinkTypeRepository implements ILinkTypeRepository
{
    private LinkType $linktype;

    public function __construct(LinkType $linktype) {
        $this->linktype = $linktype;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->linktype->all();
    }
}