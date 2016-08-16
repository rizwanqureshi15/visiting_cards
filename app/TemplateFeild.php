<?php

namespace App;

use Illuminate\Foundation\Auth\TemplateFeild as Authenticatable;

class TemplateFeild extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'id', 'name', 'template_id', 'css', 'font_css',

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}
