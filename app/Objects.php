<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Objects
 *
 * @package   Objects
 * @author    webdesignandsolution15@gmail.com
 * @link      http://www.webdesignandsolution.com/
 */
class Objects extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'id', 'name', 'css', 'is_back', 'template_id','type' , 'line_css'
    ];

    
   
}
