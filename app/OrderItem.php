<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * OrderItem
 *
 * @package   OrderItem
 * @author    webdesignandsolution15@gmail.com
 * @link      http://www.webdesignandsolution.com/
 */
class OrderItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'id', 'order_id', 'front_snap', 'back_snap' 
    ];

    
   
}
