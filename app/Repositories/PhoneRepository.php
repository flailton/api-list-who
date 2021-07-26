<?php

namespace App\Repositories;

use App\Models\Phone;
use App\Interfaces\IPhoneRepository;

class PhoneRepository implements IPhoneRepository
{
    private Phone $phone;

    public function __construct(Phone $phone) {
        $this->phone = $phone;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \App\Models\Phone
     */
    public function store($attributes)
    {
        return $this->phone->create($attributes);
    }

    /**
     * Display the specified resource.
     *
     * @return \App\Models\Phone
     */
    public function show($id)
    {
        return $this->phone->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Array  $attributes
     * @return \App\Models\Phone
     */
    public function update($attributes, $id)
    {
        $phone = $this->phone->find($id);
        $phone->update($attributes);
        
        return $phone;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Phone  $phone
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $phone = $this->phone->find($id);
        $phone->delete();

        return $phone;
    }
}