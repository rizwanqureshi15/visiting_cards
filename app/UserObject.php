<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserObject extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'id', 'name', 'css', 'is_back', 'template_id','type', 'line_css'
    ];

    
   
}