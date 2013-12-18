<?php

class Context extends Eloquent
{

	public function stackrs()
	{
		return $this->hasMany( 'Stackr', 'context_id' );
	}
}