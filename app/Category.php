<?php

namespace App;

use Illuminate\Foundation\Auth\Category as Authenticatable;

class Category extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'id','name','is_delete',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}
