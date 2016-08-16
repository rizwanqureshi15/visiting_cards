<?php

namespace App;

use Illuminate\Foundation\Auth\Template as Authenticatable;

class Template extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'id', 'name', 'category_id', 'background_image', 'background_color','url','type','is_delete',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}
