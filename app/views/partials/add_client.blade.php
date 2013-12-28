@section('add_client')
      
	<div class="container">
		<div id="add_client" class="col-md-4 col-md-offset-4 form_wrapper m-form">		
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>	
			{{ Form::open(array(
					'method' 		=> 'post',
					'route'		    => 'add_client',
					'autocomplete'	=> 'off',
					'class'			=> 'form-horizontal'
				))
			}}			
				<h5 class="heading">Client Registration Form</h5>			 	
			 	 <div class="input-group">		 	 	  
					<span class='place'>*</span><span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>					
					<input type="text" class="form-control" placeholder="Full Name or Company Name" name="clientname" value="{{Input::old('clientname')}}">
				</div>
				<p class="error_msg">
					@if($errors->has('clientname'))
						@foreach($errors->get('clientname') as $name)
							{{ $name }}
						@endforeach
					@endif
				</p>

				<div class="input-group">
					  <span class='place'>*</span><span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
					  <input type="text" class="form-control" placeholder="Email Address" name="email" value="{{Input::old('email')}}">
				</div>
				<p class="error_msg">
					@if($errors->has('email'))
						@foreach($errors->get('email') as $email_errors)
							{{ $email_errors }}
						@endforeach
					@endif
				</p>

				<div class="input-group">
					  <span class='place'>*</span><span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
					  <input type="password" class="form-control" placeholder="Password" name="password">
				</div>
				<p class="error_msg">
					@if($errors->has('password'))
						@foreach($errors->get('password') as $password_errors)
							{{ $password_errors }}
						@endforeach
					@endif
				</p>

				<div class="input-group">
					  <span class="place">&nbsp;&nbsp;</span><span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>
					  <input type="text" class="form-control" placeholder="Address" name="address" value="{{Input::old('address')}}">
				</div>

				<div class="input-group">
					  <span class="place">&nbsp;&nbsp;</span><span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span>
					  <input type="text" class="form-control" onkeydown="validateNumber(event)" placeholder="Phone" name="phone" value="{{Input::old('phone')}}">
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
				<div id="btn" class="col-md-12">		    	
					<p>
						<input type="submit" class="btn btn-default" value="Create">
					</p>
			    </div>		    
			{{ Form::close() }}	
		</div> <!--- end of form_wrapper  -->
	</div>

@show