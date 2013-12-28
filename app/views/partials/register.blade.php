@extends('layouts.form_layout')	

@section('body') 

<div class="container">
	<div id="register" class="col-md-7 form_wrapper">

	{{ Form::open(array(
			'method' 		=> 'post',
			'action'		=> 'UserController@register',
			'autocomplete'	=> 'off',
			'class'			=> 'form-horizontal',
			'enctype'		=> 'multipart/form-data'
		))
	}}

	<h5 class="heading">Registeration Form</h5>

	<div class="row input-controls"> 
		<div class="col-md-12">
			<div class='input-group' id="inputFile">
				<img id="userPhoto" src="img/profile.png" alt="" />
				<div class="controls" id="photo_control">
					<input id="uploadPhoto" type="file" onchange="showPhoto(this);" class='form-control' name='profile' value="{{Input::old('profile')}}"/>					
					<div id="falsebtn" class="btn btn-default">Browse</div><span id="photo_warn">max-2mb</span>					
				</div>				
				<script>
					$(document).ready( function() {
					  $('#falsebtn').click(function(){
					    $("#uploadPhoto").click();
					  });					  
					});
					function showPhoto(input) {
				        if (input.files && input.files[0]) {
				            var reader = new FileReader();

				            reader.onload = function (e) {
				                $('#userPhoto')
				                    .attr('src', e.target.result)					                
				            };
				            reader.readAsDataURL(input.files[0]);
				        }
				    }
				</script>
			</div>
		</div>
		<p class="error_msg">
			@if($errors->has('profile'))
				@foreach($errors->get('profile') as $profile_errors)
					{{ $profile_errors }}
				@endforeach
			@endif
		</p>
	</div>

	<div class="row input-controls"> 
		<div class="col-md-6">
			<div class='input-group'>
				<span class='place'>*</span><span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
				<div class="controls">
					{{ Form::text('username', Input::get('username'),array("class" => 'form-control inputUsername',
							"placeholder"	=> 'Username'
						)) 
					}}
				</div>				
			</div>
			<p class="error_msg">
				@if($errors->has('username'))
					@foreach($errors->get('username') as $username_errors)
						{{ $username_errors }}
					@endforeach
				@endif
			</p>
		</div>
		<div class="col-md-6">
			<div class='input-group' id="inputEmail">
				<span class='place'>*</span><span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
				<div class="controls">
					{{ Form::text('email', Input::get('email'),array("class" => 'form-control',
							"placeholder"	=> 'Email Address'
							)) }}
				</div>				
			</div>
			<p class="error_msg">
				@if($errors->has('email'))
					@foreach($errors->get('email') as $email_errors)
						{{ $email_errors }}
					@endforeach
				@endif
			</p>
		</div>
	</div>

	<div class="row input-controls">
		<div class="col-md-6">
			<div class='input-group'>
				<span class='place'>*</span><span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
				<div class="controls">
					{{ Form::password('password',array("class" => 'form-control inputPassword','placeholder' => 'Password' )) }}
				</div>				
			</div>
			<p class="error_msg">
				@if($errors->has('password'))
					@foreach($errors->get('password') as $password_errors)
						{{ $password_errors }}
					@endforeach
				@endif
			</p>
		</div>

		<div class="col-md-6">
			<div class='input-group'>
				<span class="place">*</span><span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
				<div class="controls">
					{{ Form::password('password_confirmation',array("class" => 'form-control inputPassword','placeholder' => 'Confirm Password' )) }}
				</div>
			</div>
			<p class="error_msg">
				@if($errors->has('password_confirmation'))
					@foreach($errors->get('password_confirmation') as $password_errors)
						{{ "confirm password field is required" }}
					@endforeach
				@endif
			</p>
		</div>
	</div>

	<div class="row input-controls">
		<div class='col-md-6'>
			<div class='input-group'>
				<span class="place">*</span> <span class="input-group-addon"><span class="glyphicon glyphicon-font"></span></span>
				<div class="controls">
					{{ Form::text('fullname', Input::get('fullname'), array("class" => 'form-control','placeholder' => 'Full Name' )) }}
				</div>					
			</div>
			<p class="error_msg">
				@if($errors->has('fullname'))
					@foreach($errors->get('fullname') as $fullname_errors)
						{{ $fullname_errors }}
					@endforeach
				@endif
			</p>		
		</div>		

		<div class='input-group col-md-6'>
			<span class="place">&nbsp;&nbsp;</span> <span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>
			<div class="controls">
				{{ Form::text('address', Input::get('address'), array("class" => 'form-control','placeholder' => 'Address' )) }}
			</div>			
		</div>
	</div>

	<div class="row input-controls">
		<div class='input-group col-md-6'>
			<span class="place">&nbsp;&nbsp;</span> <span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span>
			<div class="controls">
				{{ Form::text('phone', Input::get('phone'), array("class" => 'form-control','placeholder' => 'Phone', 'onkeydown'=>
				'validateNumber(event)' )) }}
			</div>			
		</div>		
	</div>
			
	<div id="btn" class="col-md-12">
		<p>
		{{ Form::submit('Register', array('class' => 'btn btn-default btnSubmit')) }}
		</p>			
	</div>
</div>
</div>

{{ Form::close() }}

@stop