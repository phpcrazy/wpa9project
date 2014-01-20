<!--
	Author		 = Sat Kyar
	StartDate 	 = 28 Dec 2013
	ModifiedDate = 14 Jan 2014
	Purpose	 = To add client
	Remark
		0 Validating phone to only numeric => js.ValidateNumber in phone field
-->

@section('add_client')     

	<div class='container'>
		<div id='add_client' class='col-md-4 col-md-offset-4 form_wrapper m-form'>		
			<button type='button' class='close' data-dismiss='modal'
			 aria-hidden='true'>&times;</button>	
			{{ Form::open(array(
					'method' 		=> 'post',
					'route'		    => 'add_client',
					'autocomplete'	=> 'off',
					'class'			=> 'form-horizontal' ))
			}}			
			<h5 class='heading'>{{Lang::get('caption.title.add_client')}}</h5>			 	
		 	 <div class='input-group'>		 	 	  
				<span class='place'>*</span>
				<span class='input-group-addon'><span class='glyphicon glyphicon-user'></span></span>					
				{{ Form::text('email', Input::old('clientname'),
					array('class'		=> 'form-control',
						  'placeholder'	=> Lang::get('caption.label.add_client.clientname'),
						  'name'		=> 'clientname'	)) 
				}}					
			</div>
			<p class='error_msg'>
				@if($errors->has('clientname'))
					{{ $errors->get('clientname')[0];}}						
				@endif
			</p>

			<div class='input-group'>
				<span class='place'>*</span>
				<span class='input-group-addon'><span class='glyphicon glyphicon-envelope'></span></span>
				{{ Form::text('email', Input::old('email'),
					array('class'		=> 'form-control',
						  'placeholder'	=> 	Lang::get('caption.label.add_client.email'))) 
				}}
			</div>
			<p class='error_msg'>
				@if($errors->has('email'))
					{{ $errors->get('email')[0];}}				
				@endif
			</p>

			<div class='input-group'>
				<span class='place'>*</span>
				<span class='input-group-addon'><span class='glyphicon glyphicon-lock'></span></span>
				{{ Form::password('password',
					array('class' => 'form-control inputPassword',
						  'placeholder' =>  Lang::get('caption.label.add_client.pass'))) 
				}}
			</div>
			<p class='error_msg'>
				@if($errors->has('password'))
					{{ $errors->get('password')[0];}}		
				@endif
			</p>

			<div class='input-group'>
				<span class='place'>&nbsp;&nbsp;</span>
				<span class='input-group-addon'><span class='glyphicon glyphicon-home'></span></span>
			  	{{ Form::text('address', Input::old('address'), 
			  		array('class' => 'form-control',
			  			  'placeholder' =>  Lang::get('caption.label.add_client.add'))) 
			  	}}
			</div>

			<div class='input-group'>
			  	<span class='place'>&nbsp;&nbsp;</span>
			  	<span class='input-group-addon'><span class='glyphicon glyphicon-phone'></span></span>
			  	{{ Form::text('phone', Input::old('phone'), 
			  		array('class' => 'form-control',
			  		  	  'placeholder' => Lang::get('caption.label.add_client.ph'), 
			  		  	  'onkeydown'=>	'validateNumber(event)' )) 
			  	}}					  
			</div>
					  
			<div id='btn' class='col-md-12'>		    	
				<p>
					{{ Form::submit(Lang::get('caption.link.button.register'), array('class' => 'btn btn-default', 'id' => 'btnSubmit')) }}	
				</p>
		    </div>		    
			{{ Form::close() }}	
		</div> <!--- end of form_wrapper  -->
	</div>

@show