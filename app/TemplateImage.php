<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TemplateImage extends model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'id', 'template_id', 'src', 'css', 'shape',
    ];
   
}
