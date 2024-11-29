<?php

namespace App\Models;

class Screening
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'is_showing',
        'screen_end'
    ];
   
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created' => 'datetime',
        'updated' => 'datetime',
    ];
}
