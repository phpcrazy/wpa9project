<!--
	Author		 = Sat Kyar
	StartDate 	 = 28 Dec 2013
	ModifiedDate = 14 Jan 2014
	Purpose	 = To add project
	Remark
		0 Checking DueDate not greater than StartDate => js.ValidateDate in #btnSubmit
-->

@section('add_project')

<div class='container'>	
	<div id='add_project' class='col-md-4 col-md-offset-4 form_wrapper m-form'>		
			<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
		{{ Form::open(array(
			'method' 		=> 'post',
			'route'			=> 'add_project',
			'autocomplete'	=> 'off',	
			'class'			=> 'form-horizontal',
			'name'			=> 'project' ))
		}}
		<h5 class='heading'>{{Lang::get('caption.title.add_project')}}</h5>
		<div class='input-group'>
			<span class='place'>*</span><span class='input-group-addon'><span class='glyphicon glyphicon-book'></span></span>					
				{{ Form::text('projectname', Input::old('projectname')
					,array('class'  		=> 'form-control', 
						   'placeholder'	=> Lang::get('caption.label.add_project.projectname') 
  				    )) 
				}}
		</div>
		<p class='error_msg'>
			@if($errors->has('projectname'))
				{{ $errors->get('projectname')[0];}}
			@endif
		</p>		

		<div class='input-group'>				
			<span class='place'>&nbsp;&nbsp;</span>
			<span class='input-group-addon'><span class='glyphicon glyphicon-list'></span></span>
				{{ Form::text('desc', Input::old('desc'), 
					array('class' 		=> 'form-control', 
						  'placeholder'	=> Lang::get('caption.label.add_project.desc') 
					)) 
				}}
		</div>

		<div class='input-group'>
			<span class='place'>*</span>
				{{ Form::text('startDate',Input::old('startDate'),
			  		array('class' 			  => 'form-control date_picker',
			  			  'data-date-format'  => 'dd-MM-yyyy', 
			  			  'placeholder'  	  => Lang::get('caption.label.add_project.start_date') ,
			  			  'id'				  => 'StartDate', 'readonly'))
				}}
		  	<span class='input-group-addon'><i class='glyphicon glyphicon-calendar'></i></span>
		</div>
		<p class='error_msg' id='startDate_error'>
			@if($errors->has('startDate'))
				{{ $errors->get('startDate')[0];}}					
			@endif
		</p>

		<div class='input-group'>
			<span class='place'>*</span>
			    {{ Form::text('dueDate',Input::old('dueDate'),
					array('class'            => 'form-control date_picker', 
						  'data-date-format' => 'dd-MM-yyyy', 
						  'placeholder'		 => Lang::get('caption.label.add_project.due_date') ,
						  'id' 		 		 => 'DueDate', 'readonly'))
				}}
			<span class='input-group-addon'><i class='glyphicon glyphicon-calendar'></i></span>
		</div>
		<p class='error_msg' id='due_error'>
			@if($errors->has('dueDate'))
				{{ $errors->get('dueDate')[0];}}									
			@endif
		</p>

		<div class='input-group'>				
			<span class='place'>&nbsp;&nbsp;</span></span>
			<select class='form-control' name='client'>
				<option>{{Lang::get('caption.label.add_project.client')}} </option>
				@foreach($para['client'] as $client)
					@if(Session::hasOldInput('client'))
						@if(Input::old('client') == $client->clientId)								
							<option selected='true' value='{{$client->clientId}}'>{{ $client->client }}</option>								
						@else
							<option value='{{$client->clientId}}'>{{ $client->client }}</option>
						@endif
					@else				
					<option value='{{$client->clientId}}'>{{ $client->client }}</option>
					@endif
				@endforeach
			</select>
		</div>

		<div id='btn' class='col-md-12'>
			<p>
				{{ Form::button(Lang::get('caption.link.button.create'), array('class' => 'btn btn-default', 'id' => 'btnSubmit')) }}	
			</p>			
		</div>	

		{{ Form::close() }}
	</div>						

</div> <!--- end of container -->

@show
