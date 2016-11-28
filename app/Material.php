<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Material
 *
 * @package   Material
 * @author    webdesignandsolution15@gmail.com
 * @link      http://www.webdesignandsolution.com/
 */
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
