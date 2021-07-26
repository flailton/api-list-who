<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the links associated with the contact.
     */
    public function links()
    {
        return $this->hasMany(Link::class);
    }

    /**
     * Get the phones associated with the contact.
     */
    public function phones()
    {
        return $this->hasMany(Phone::class);
    }
}
