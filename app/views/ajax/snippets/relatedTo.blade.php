<?
	// compose url
	$relatedStackrUrl = url( '/contexts/' . $relatedStackr->context->name . '/stackrs#' . $relatedStackr->id ); 
?>

<a class='dotted element-tooltip' href='{{ $relatedStackrUrl }}' title='<h3>{{ e( $relatedStackr->title ) }}</h3><span>{{ e( $relatedStackr->description ) }}</span>''>related to #{{ $stackr->relatedTo }}</a>