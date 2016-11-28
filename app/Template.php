<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TemplateFeild;


/**
 * Template
 *
 * @package   Template
 * @author    webdesignandsolution15@gmail.com
 * @link      http://www.webdesignandsolution.com/
 */
class Template extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'id', 'name', 'category_id', 'background_image', 'background_color','url','type','is_delete','is_both_side', 'background_image_back', 'back_snap', 'snap'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function template_feilds()
    {
        return $this->hasMany('App\TemplateFeild');
    }

    public function template_images()
    {
        return $this->hasMany('App\TemplateImage');
    }
}
