<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Order
 *
 * @package   Order
 * @author    webdesignandsolution15@gmail.com
 * @link      http://www.webdesignandsolution.com/
 */
class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'id', 'user_id', 'material_id', 'amount', 'quantity', 'is_cancel', 'status', 'is_delete' , 'order_no', 'is_confirmed', 'address_1', 'address_2', 'city', 'state', 'country', 'zipcode', 'shipping_address_line_1', 'shipping_address_line_2', 'shipping_city', 'shipping_state', 'shipping_country', 'shipping_zipcode', 'user_template_id', 'payu_money_id'
    ];

    
  public function user()
  {
  	 return $this->belongsTo('App\User');
  }
}
