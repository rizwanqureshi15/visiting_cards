<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTemplateImage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'id', 'template_id','user_id','src', 'css','div_css', 'shape',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}
