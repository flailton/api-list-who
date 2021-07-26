<?php

namespace App\Repositories;

use App\Models\Link;
use App\Interfaces\ILinkRepository;

class LinkRepository implements ILinkRepository
{
    private Link $link;

    public function __construct(Link $link) {
        $this->link = $link;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \App\Models\Link
     */
    public function store($attributes)
    {
        return $this->link->create($attributes);
    }

    /**
     * Display the specified resource.
     *
     * @return \App\Models\Link
     */
    public function show($id)
    {
        return $this->link->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Array  $attributes
     * @return \App\Models\Link
     */
    public function update($attributes, $id)
    {
        $link = $this->link->find($id);
        $link->update($attributes);
        
        return $link;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $link = $this->link->find($id);
        $link->delete();

        return $link;
    }
}