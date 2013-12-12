<?php 

class Stackr extends Eloquent 
{

	public function comments()
	{
		return $this->hasMany( 'Comment', 'stackr_id' );
	}

	public static function distinctTagList()
	{
		return DB::table( 'Stackrs' )->select( DB::raw( "group_concat( distinct tags separator ', ' ) as tags" ))->get();
	}
}