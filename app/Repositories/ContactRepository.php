<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Interfaces\IContactRepository;

class ContactRepository implements IContactRepository
{
    private Contact $contact;

    public function __construct(Contact $contact) {
        $this->contact = $contact;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->contact->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \App\Models\Contact
     */
    public function store($attributes)
    {
        return $this->contact->create($attributes);
    }

    /**
     * Display the specified resource.
     *
     * @return \App\Models\Contact
     */
    public function show($id)
    {
        return $this->contact->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Array  $attributes
     * @return \App\Models\Contact
     */
    public function update($attributes, $id)
    {
        $contact = $this->contact->find($id);
        $contact->update($attributes);
        
        return $contact;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = $this->contact->find($id);
        $contact->delete();

        return $contact;
    }
}