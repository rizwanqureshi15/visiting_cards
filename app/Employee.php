<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;


/**
 * Employee
 *
 * @package   Employee
 * @author    webdesignandsolution15@gmail.com
 * @link      http://www.webdesignandsolution.com/
 */
class Employee extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'username', 'is_admin', 'is_delete'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getRememberToken()
      {
        return null; // not supported
      }

      public function setRememberToken($value)
      {
        // not supported
      }

      public function getRememberTokenName()
      {
        return null; // not supported
      }

      /**
       * Overrides the method to ignore the remember token.
       */
      public function setAttribute($key, $value)
      {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (!$isRememberTokenAttribute)
        {
          parent::setAttribute($key, $value);
        }
      }
}
