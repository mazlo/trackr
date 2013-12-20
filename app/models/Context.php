<?php

class Context extends Eloquent
{

	public function stackrs()
	{
		return $this->hasMany( 'Stackr', 'context_id' );
	}

	public function user()
	{
		return $this->belongsTo( 'User', 'user_id' );
	}
}