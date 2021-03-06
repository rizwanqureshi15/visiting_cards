<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * UserTemplateImage
 *
 * @package   UserTemplateImage
 * @author    webdesignandsolution15@gmail.com
 * @link      http://www.webdesignandsolution.com/
 */
class UserTemplateImage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'id', 'user_id','src', 'template_feild_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}
