<?php

namespace App\Models;

class Theater
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'location_name',
        'city',
        'state',
        'street',
        'zip5'
    ];
   
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created' => 'datetime',
    ];
}
