<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Material extends model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'id', 'name', 'price', 'description', 'is_delete' ,'image'
    ];
   
}
