@extends('layouts.form_layout')

<!--
	Author		 = Sat Kyar
	StartDate 	 = 28 Dec 2013
	ModifiedDate = 14 Jan 2014
	Purposse	 = To add client
	Remark
		0 Validating phone to only numeric => js.ValidateNumber in phone field
-->

@section('body')

<div class='container'>

	<div id='login' class='col-md-4 col-md-offset-4 form_wrapper b-form'>

		{{ Form::open(array(
			'method'		=> 'post',
			'route'			=> 'login',
			'autocomplete'	=> 'off',
			'class'			=> 'form-horizontal'
			))
		}}
		@if($errors->has('auth_errors'))
			{{ $errors->get('auth_errors') }}
		@endif

		<h5 class='heading'>{{Lang::get('caption.title.login')}}</h5>

		<div class='input-group'>			
			<span class='input-group-addon'><span class='glyphicon glyphicon-user'></span></span>
			<div class='controls'>
				{{ Form::text('email', Input::old('email'), array('class' => 'form-control',
				'placeholder'	=> Lang::get('caption.label.login.email')
				)) }}
			</div>			
		</div>	
		<p class='error_msg'>
			@if($errors->has('email'))
				{{ $errors->get('email')[0];}}				
			@endif
		</p>
		<div class='input-group'>			
			<span class='input-group-addon'><span  class='glyphicon glyphicon-lock'></span></span>
			<div class='controls'>
				{{ Form::input('password', 'password', Input::old('password'), 
					array('class'		=> 'form-control',
						  'placeholder'	=> Lang::get('caption.label.login.password')
				)) }}		
			</div>			
		</div>
		<p class='error_msg'>
			@if($errors->has('password'))
				{{ $errors->get('password')[0];}}	
			@endif
		</p>

		<div class='form-group' id='login_options'>
			<div class='col-md-6 checkbox'>
		    		{{ Form::checkbox('keepLogin')}}
		    		{{ Form::label('keep', Lang::get('caption.label.login.r_me'), array('class' => 'control-label')) }}		    		
			</div>

	    	<div class='col-md-6'>				      
		         <a href='#'>{{Lang::get('caption.link.link.forgot_pass')}}</a>			  
		    </div>		    
		</div>

	    <div class='col-md-12' id='btn'>		    
			<p>
				{{ Form::submit(Lang::get('caption.link.button.login'), array('class' => 'btn btn-default', 'id' => 'btnSubmit')) }}	
				 Or <a href='{{route('register_first')}}'>{{Lang::get('caption.link.link.sign_up')}}</a>
			</p>
	    </div>

</div>

{{ Form::close() }}

@stop