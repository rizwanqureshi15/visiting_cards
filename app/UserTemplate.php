<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserTemplateFeild;

class UserTemplate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'id', 'name', 'category_id','user_id','background_image', 'background_color','url','type','is_delete','template_id','snap'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function user_template_feilds()
    {
        return $this->hasMany('App\UserTemplateFeild');
    }

}