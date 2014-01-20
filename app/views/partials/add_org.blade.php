@extends('layouts.form_layout')

<!--
	Author		 = Sat Kyar
	StartDate 	 = 28 Dec 2013
	ModifiedDate = 14 Jan 2014
	Purpose		 = To add organization
	Remark
-->

@section('body')

<div class='container'>

	<div id='org' class='col-md-4 col-md-offset-4 form_wrapper'>
	{{ Form::open(array(
		'method'		=> 'POST',
		'route'		    => 'add_org',
		'autocomplete'	=> 'off',
		'class'			=> 'form-horizontal'
		))
	}}

	<h5 class='heading'>{{Lang::get('caption.title.add_org')}}</h5>

	<div class='input-group'>			
		<span class='input-group-addon'><span class='glyphicon glyphicon-globe'></span></span>
		<div class='controls'>
			{{ Form::text('org', Input::old('org'),
				 array('class' => 'form-control', 'placeholder'	=> Lang::get('caption.label.add_org.org')	))
			}}
		</div>			
	</div>	
	<p class='error_msg'>
		@if($errors->has('org'))
			{{ $errors->get('org')[0];}}
		@endif
	</p>

     <div class='col-md-12' id='btn'>		    
		<p>
			{{ Form::submit(Lang::get('caption.link.button.create'), array('class' => 'btn btn-default', 'id' => 'btnSubmit')) }}	
		</div>
	</div>

	{{ Form::close() }}

@stop