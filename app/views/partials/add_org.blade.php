@extends('layouts.form_layout')

@section('body')
<div class="container">

	<div id="org" class="col-md-4 col-md-offset-4 form_wrapper">
	{{ Form::open(array(
		'method'		=> 'POST',
		'route'		    => 'add_org',
		'autocomplete'	=> 'off',
		'class'			=> 'form-horizontal'
		))
	}}

	<h5 class="heading">Organization Register Form</h5>

	<div class="input-group">			
		<span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
		<div class="controls">
			{{ Form::text('org', Input::old('org'), array("class" => 'form-control',
			"placeholder"	=> 'Your Organization Name'
			)) }}
		</div>			
	</div>	
	<p class="error_msg">
		@if($errors->has('org'))
			@foreach($errors->get('org') as $error)
			{{ $error }}
			@endforeach
		@endif
	</p>

     <div class="col-md-12" id="btn">		    
		<p>
			{{ Form::submit('Create', array('class' => 'btn btn-default')) }}
		</div>
	</div>

	{{ Form::close() }}

@stop