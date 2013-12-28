@section('add_member') 

<div class="container">
	<div id="register" class="col-md-7 form_wrapper m-form">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>	
	{{ Form::open(array(
			'method' 		=> 'post',
			'route'		    => 'add_member',
			'autocomplete'	=> 'off',
			'class'			=> 'form-horizontal',
			'enctype'		=> 'multipart/form-data'
		))
	}}

	<h5 class="heading">Member Registeration Form</h5>

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
			<script>
				function validateNumber(evt) {
				    var e = evt || window.event;
				    var key = e.keyCode || e.which;

				    if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
				    // numbers   
				    key >= 48 && key <= 57 ||
				    // Numeric keypad
				    key >= 96 && key <= 105 ||
				    // Backspace and Tab and Enter
				    key == 8 || key == 9 || key == 13 ||
				    // Home and End
				    key == 35 || key == 36 ||
				    // left and right arrows
				    key == 37 || key == 39 ||
				    // Del and Ins
				    key == 46 || key == 45) {
				        // input is VALID
				    }
				    else {
				        // input is INVALID
				        e.returnValue = false;
				        if (e.preventDefault) e.preventDefault();
				    }
				}
				// comma, period and minus, . on keypad  key == 190 || key == 188 || key == 109 || key == 110 ||
 
			</script>
		</div>		
	</div>
			
	<div id="btn" class="col-md-12">
		<p>
		{{ Form::submit('Register', array('class' => 'btn btn-default btnSubmit')) }}
		</p>			
	</div>
	{{ Form::close() }}
</div>
</div>



@show