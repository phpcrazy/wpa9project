@extends('layouts.form_layout')

@section('body')

<div class="container">

	<div id="login" class="col-md-4 col-md-offset-4 form_wrapper b-form">

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

		<h5 class="heading">Login Form</h5>

		<div class="input-group">			
			<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
			<div class="controls">
				{{ Form::text('email', Input::old('email'), array("class" => 'form-control',
				"placeholder"	=> 'Email'
				)) }}
			</div>			
		</div>	
		<p class="error_msg">
			@if($errors->has('email'))
				@foreach($errors->get('email') as $error)
					{{ $error }}
				@endforeach
			@endif
		</p>
		<div class="input-group">			
			<span class="input-group-addon"><span  class="glyphicon glyphicon-lock"></span></span>
			<div class="controls">
				{{ Form::input("password", "password", Input::old('password'), array("class" => 'form-control',
					"placeholder"	=> 'Password'
				)) }}		
			</div>			
		</div>
		<p class="error_msg">
			@if($errors->has('password'))
				@foreach($errors->get('password') as $error)
					{{ $error }}
				@endforeach
			@endif
		</p>

		<div class="form-group" id="login_options">
			<div class="col-md-6 checkbox">
		    		{{ Form::checkbox("keepLogin")}}
		    		{{ Form::label("keep", 'Remember Me', array('class' => 'control-label')) }}		    		
			</div>

	    	<div class="col-md-6">				      
		         <a href="#">Forgot Password?</a>			  
		    </div>		    
		</div>

	    <div class="col-md-12" id="btn">		    
			<p>
				{{ Form::submit('Login', array('class' => 'btn btn-default')) }}
				 Or <a href="{{route('register_first')}}" onClick="">Sign Up</a>
			</p>
	    </div>

</div>

{{ Form::close() }}

@stop