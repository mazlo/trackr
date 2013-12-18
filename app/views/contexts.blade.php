@extends( 'layout' )

@section( 'beforeContent' )

@stop

@section( 'content' )

	<div style='padding: 23px;'>
	@foreach( $contexts as $context )
		
		<div style='display: inline-block; border: 1px #bbb solid; width: 200px; height: 152px; margin: 0px 32px 32px 0; padding-top: 48px; text-align: center;'>
			{{ $context->name }}
		</div>

	@endforeach
	</div>

@stop