<?php

class Comment extends Eloquent 
{

	public function user()
	{
		return $this->belongsTo( 'User', 'user_id' );
	}
}