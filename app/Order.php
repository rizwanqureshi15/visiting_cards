<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'id', 'user_id', 'material_id', 'amount', 'quantity', 'is_cancel', 'status', 'is_delete' , 'order_no', 'is_confirmed',
    ];

    
  public function user()
  {
  	 return $this->belongsTo('App\User');
  }
}
