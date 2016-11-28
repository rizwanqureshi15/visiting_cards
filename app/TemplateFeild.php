<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * TemplateFeild
 *
 * @package   TemplateFeild
 * @author    webdesignandsolution15@gmail.com
 * @link      http://www.webdesignandsolution.com/
 */
class TemplateFeild extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [

        'id', 'name', 'template_id', 'css', 'font_css', 'content', 'is_label', 'is_back',
        ];
}
