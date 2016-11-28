<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * FinalOrder
 *
 * @package   FinalOrder
 * @author    webdesignandsolution15@gmail.com
 * @link      http://www.webdesignandsolution.com/
 */
class FinalOrder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'id', 
        'order_id',
        'snap',
        'is_back', 
    ];
}
