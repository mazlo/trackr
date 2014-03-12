<?
	// compose url
	$relatedStackrUrl = url( '/contexts/' . $relatedStackr->context->name . '/stackrs#' . $relatedStackr->id ); 
?>

<a class='dotted element-tooltip' href='{{ $relatedStackrUrl }}' title='{{ $relatedStackr->title }}'>related to #{{ $stackr->relatedTo }}</a>