<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Contact
 *
 * @package   Contact
 * @author    webdesignandsolution15@gmail.com
 * @link      http://www.webdesignandsolution.com/
 */
class Contact extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'id', 'name', 'email', 'subject', 'content', 'is_delete'
    ];
}
