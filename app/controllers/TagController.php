<?php

class TagController extends BaseController 
{
	function getDistinctTagList()
	{
		$tagList = Stackr::distinctTagList();

		return View::make( 'ajax.distinctTagList' )->with( 'tagList', $tagList );
	}
}
