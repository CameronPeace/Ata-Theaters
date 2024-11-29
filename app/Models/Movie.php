<?php

namespace App\Models;

class Movie
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'genre',
        'director',
        'poster_url',
        'release_date'
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
