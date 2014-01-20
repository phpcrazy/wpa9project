<!--
	Author		 = Sat Kyar
	StartDate 	 = 28 Dec 2013
	ModifiedDate = 14 Jan 2014
	Purpose	 	 = To add member
	Remark
		0 Validating phone to only numeric => js.ValidateNumber in phone field
		0 Profile photo uploading => js.falsebtn_Click & showPhoto
-->

@section('add_member') 

<div class='container'>
	<div id='register' class='col-md-7 form_wrapper m-form'>
	<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>	
	{{ Form::open(array(
			'method' 		=> 'post',
			'route'		    => 'add_member',
			'autocomplete'	=> 'off',
			'class'			=> 'form-horizontal',
			'enctype'		=> 'multipart/form-data'
		))
	}}

	<h5 class='heading'>{{Lang::get('caption.title.add_member')}}</h5>

	<div class='row input-controls'> 
		<div class='col-md-12'>
			<div class='input-group' id='inputFile'>
				<img id='userPhoto' src='img/profile.png' alt='' />
				<div class='controls' id='photo_control'>
					<input id='uploadPhoto' type='file' onchange='showPhoto(this);' class='form-control' name='profile' value='{{Input::old('profile')}}'/>					
					<div id='falsebtn' class='btn btn-default'>Browse</div><span id='photo_warn'>{{Lang::get('caption.label.register.photo_warn')}}</span>					
				</div>								
			</div>
		</div>
		<p class='error_msg'  id='profilePhoto'>
			@if($errors->has('profile'))
				{{ $errors->get('profile')[0];}}						
			@endif
		</p>
	</div>

	<div class='row input-controls'> 
		<div class='col-md-6'>
			<div class='input-group'>
				<span class='place'>*</span>
				<span class='input-group-addon'><span class='glyphicon glyphicon-user'></span></span>
				<div class='controls'>
					{{ Form::text('username', Input::old('username'),
						array('class'		=> 'form-control inputUsername',
							  'placeholder'	=> Lang::get('caption.label.register.username')
					   )) 
					}}
				</div>				
			</div>
			<p class='error_msg'>
				@if($errors->has('username'))
					{{ $errors->get('username')[0];}}						
				@endif
			</p>
		</div>
		<div class='col-md-6'>
			<div class='input-group' id='inputEmail'>
				<span class='place'>*</span>
				<span class='input-group-addon'><span class='glyphicon glyphicon-envelope'></span></span>
				<div class='controls'>
					{{ Form::text('email', Input::old('email'),
						array('class'		=> 'form-control',
							  'placeholder'	=> Lang::get('caption.label.register.email')
						)) 
					}}
				</div>				
			</div>
			<p class='error_msg'>
				@if($errors->has('email'))
					{{ $errors->get('email')[0];}}						
				@endif
			</p>
		</div>
	</div>

	<div class='row input-controls'>
		<div class='col-md-6'>
			<div class='input-group'>
				<span class='place'>*</span>
				<span class='input-group-addon'><span class='glyphicon glyphicon-lock'></span></span>
				<div class='controls'>
					{{ Form::password('password',
						array('class' => 'form-control inputPassword',
							  'placeholder' => Lang::get('caption.label.register.pass')
					    )) 
					}}
				</div>				
			</div>
			<p class='error_msg'>
				@if($errors->has('password'))
					{{ $errors->get('password')[0];}}						
				@endif
			</p>
		</div>

		<div class='col-md-6'>
			<div class='input-group'>
				<span class='place'>*</span>
				<span class='input-group-addon'><span class='glyphicon glyphicon-lock'></span></span>
				<div class='controls'>
					{{ Form::password('password_confirmation',
						array('class' 		=> 'form-control inputPassword',
							  'placeholder' => Lang::get('caption.label.register.c_pass')
					    )) 
					}}
				</div>
			</div>
			<p class='error_msg'>
				@if($errors->has('password_confirmation'))
					{{ $errors->get('password_confirmation')[0];}}			
				@endif
			</p>
		</div>
	</div>

	<div class='row input-controls'>
		<div class='col-md-6'>
			<div class='input-group'>
				<span class='place'>*</span> 
				<span class='input-group-addon'><span class='glyphicon glyphicon-font'></span></span>
				<div class='controls'>
					{{ Form::text('fullname', Input::old('fullname'), 
						array('class' 		=> 'form-control',
							  'placeholder' => Lang::get('caption.label.register.member_name')
					    )) 
					}}
				</div>					
			</div>
			<p class='error_msg'>
				@if($errors->has('fullname'))
					{{ $errors->get('fullname')[0];}}			
				@endif
			</p>		
		</div>		

		<div class='input-group col-md-6'>
			<span class='place'>&nbsp;&nbsp;</span> 
			<span class='input-group-addon'><span class='glyphicon glyphicon-home'></span></span>
			<div class='controls'>
				{{ Form::text('address', Input::old('address'), 
					array('class' 		=> 'form-control',
						  'placeholder' => Lang::get('caption.label.register.add')
				    )) 
				}}
			</div>			
		</div>
	</div>

	<div class='row input-controls'>
		<div class='input-group col-md-6'>
			<span class='place'>&nbsp;&nbsp;</span> 
			<span class='input-group-addon'><span class='glyphicon glyphicon-phone'></span></span>
			<div class='controls'>
				{{ Form::text('phone', Input::get('phone'), 
					array('class' 		=> 'form-control',
						  'placeholder' => Lang::get('caption.label.register.ph'), 
						  'onkeydown'	=> 'validateNumber(event)' )) 
				}}
			</div>			
		</div>		
	</div>
			
	<div id='btn' class='col-md-12'>
		<p>
		{{ Form::submit(Lang::get('caption.link.button.register'), array('class' => 'btn btn-default', 'id' => 'btnSubmit')) }}
		</p>			
	</div>
	{{ Form::close() }}
</div>
</div>

@show