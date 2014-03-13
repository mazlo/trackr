<?
	// compose url
	$relatedStackrUrl = url( '/contexts/' . $relatedStackr->context->name . '/stackrs#' . $relatedStackr->id ); 
?>

<a class='dotted element-tooltip' href='{{ $relatedStackrUrl }}' title='<h3>{{ e( $relatedStackr->title ) }}</h3><p>{{ e( $relatedStackr->description ) }}</p>''>related to #{{ $stackr->relatedTo }}</a>