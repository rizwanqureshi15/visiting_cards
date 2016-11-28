<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Faq
 *
 * @package   Faq
 * @author    webdesignandsolution15@gmail.com
 * @link      http://www.webdesignandsolution.com/
 */
class Faq extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'id', 'is_delete', 'question', 'answer',
    ];
}
