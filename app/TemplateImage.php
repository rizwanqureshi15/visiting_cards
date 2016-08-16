<?php

namespace App;

use Illuminate\Foundation\Auth\TemplateImage as Authenticatable;

class TemplateImage extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'id', 'template_id', 'src', 'css', 'shape',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}
