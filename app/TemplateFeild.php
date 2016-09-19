<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemplateFeild extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [

        'id', 'name', 'template_id', 'css', 'font_css', 'content', 'is_label'
        ];
}
