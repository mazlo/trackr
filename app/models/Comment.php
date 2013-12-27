<?php

class Comment extends Eloquent 
{

	public function stackr()
	{
		return $this->belongsTo( 'Stackr', 'stackr_id' );
	}

	public function user()
	{
		return $this->belongsTo( 'User', 'user_id' );
	}
}