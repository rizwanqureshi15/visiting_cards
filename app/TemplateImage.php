<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * TemplateImage
 *
 * @package   TemplateImage
 * @author    webdesignandsolution15@gmail.com
 * @link      http://www.webdesignandsolution.com/
 */
class TemplateImage extends model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'id', 'template_id', 'src', 'css','div_css', 'shape',
    ];
   
}
