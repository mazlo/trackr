<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	* Properties
	*/
	
	public function contexts()
    {
        return $this->hasMany( 'Context', 'user_id' );
    }

    public function context( $cname )
    {
    	return $this->hasMany( 'Context', 'user_id' )->where( 'name', $cname );
    }

    public function stackrs( $cname )
    {
    	return $this->context( $cname )->first()->stackrs();
    }

    public function stackr( $cname, $sid )
    {
    	return $this->stackrs( $cname )->where( 'id', $sid );
    }

    public function comments( $cname, $sid )
    {
    	return $this->stackr( $cname, $sid )->comments();
    }

    public function comment( $cid )
    {
    	return $this->hasMany( 'Comment', 'user_id' )->where( 'id', $cid );
    }

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

}