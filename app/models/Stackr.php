<?php 

class Stackr extends Eloquent 
{

	public function comments()
	{
		return $this->hasMany( 'Comment', 'stackr_id' );
	}

	public function user()
	{
		return $this->belongsTo( 'User', 'user_id' );
	}

	public function context()
	{
		return $this->belongsTo( 'Context', 'context_id' );
	}

	public static function distinctTagList( $cname )
	{
		return DB::table( 'Stackrs' )
			->select( DB::raw( 'group_concat( distinct tags separator ", " ) as tags' ))
			->join( 'Contexts', 'Stackrs.context_id', '=', 'Contexts.id' )
			->where( 'Stackrs.user_id', Auth::user()->id )
			->where( 'Contexts.name', $cname )
			->get();
	}
}