<?php

class TagController extends BaseController 
{
	function getDistinctTagList()
	{
		$tagList = Stackr::distinctTagList();

		return View::make( 'ajax_distinctTagList' )->with( 'tagList', $tagList );
	}
}
