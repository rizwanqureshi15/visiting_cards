<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TemplateFeild;

class Template extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'id', 'name', 'category_id', 'background_image', 'background_color','url','type','is_delete',
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