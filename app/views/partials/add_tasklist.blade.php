<!--
	Author		 = Sat Kyar
	StartDate 	 = 28 Dec 2013
	ModifiedDate = 14 Jan 2014
	Purpose	 = To add tasklist
	Remark
		0 Checking DueDate not greater than StartDate => js.ValidateDate in #btnSubmit
-->

@section('add_tasklist')

@if(!isset($para['tasklist']))
	<?php $moduleId = 0 ?>
@else
	<?php $moduleId = $para['module']->moduleId ?>
@endif

		<div class='container'>
			<div id='add_tasklist' class='col-md-4 col-md-offset-4 form_wrapper m-form'>		
				<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>	
				{{ Form::open(array(
					'method' 		=> 'post',
					'route' 		=> 'add_tasklist',
					'autocomplete'	=> 'off',
					'class'			=> 'form-horizontal',					
					'name'			=> 'tasklist'))
				}}	
				{{ Form::hidden('source','', array('class' => 'form-control', 'id' => 'Source' )) }}
				{{ Form::hidden('projectId', 0, array('class' => 'form-control' )) }}
				{{ Form::hidden('moduleId',$moduleId, array('class' => 'form-control', 'id' => 'txtModuleId' )) }}
				<h5 class='heading'>{{Lang::get('caption.title.add_tasklist')}}</h5>			 	
			 	 <div class='input-group'>	  
					<span class='place'>*</span><span class='input-group-addon'><span class='glyphicon glyphicon-th-list'></span></span>										
					{{ Form::text('tasklistname', Input::old('tasklistname')
						,array('class'  		=> 'form-control', 
							   'placeholder'	=> Lang::get('caption.label.add_tasklist.tasklistname')
						)) 
					}}
				</div>
				<p class='error_msg'>
					@if($errors->has('tasklistname'))
						{{ $errors->get('tasklistname')[0];}}		
					@endif
				</p>

				<div class='input-group'>
					  <span class='place'>&nbsp;&nbsp;</span>
					  <span class='input-group-addon'><span class='glyphicon glyphicon-list'></span></span>
					{{ Form::text('desc', Input::old('desc')
						,array('class' 		=> 'form-control',
							   'placeholder'=> Lang::get('caption.label.add_tasklist.desc')
						)) 
					}}
				</div>		

				<div class='input-group'>
					  <span class='place'>*</span>
					  {{ Form::text('startDate',Input::old('startDate'),
					  		array('class'			 	=> 'form-control date_picker',
					  			   'data-date-format'	=> 'dd-MM-yyyy', 
					  			   'placeholder'		=> Lang::get('caption.label.add_tasklist.start_date'),
					  			   'id' 				=> 'StartDate', 'readonly'))
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
							array('class'				=> 'form-control date_picker', 
								  'data-date-format'	=> 'dd-MM-yyyy', 
								  'placeholder'			=> Lang::get('caption.label.add_tasklist.due_date'),
								  'id'					=> 'DueDate', 'readonly'))
						}}
						<span class='input-group-addon'><i class='glyphicon glyphicon-calendar'></i></span>
				</div>
				<p class='error_msg' id='due_error'>
					@if($errors->has('dueDate'))
						{{ $errors->get('dueDate')[0];}}		
					@endif
				</p>					 
				<div id='btn' class='col-md-12'>		    	
					<p>
						{{ Form::button(Lang::get('caption.link.button.create'), array('class' => 'btn btn-default', 'id' => 'btnSubmit')) }}	
					</p>
			    </div>		    
			</form>		
		</div> <!--- end of form_wrapper  -->
	</div>
		
@show