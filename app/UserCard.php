<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * UserCard
 *
 * @package   UserCard
 * @author    webdesignandsolution15@gmail.com
 * @link      http://www.webdesignandsolution.com/
 */
class UserCard extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'image', 'user_id'
    ];

    
   
}
