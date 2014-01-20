<!--
	Author		 = Sat Kyar
	StartDate 	 = 28 Dec 2013
	ModifiedDate = 14 Jan 2014
	Purpose	 = To add task
	Remark
		0 Checking DueDate not greater than StartDate => js.ValidateDate in #btnSubmit
-->

@section('add_task')

@if(!isset($num))
	<?php $num = 0;	?>
@endif

	@if(!isset($para['tasklist']))
		<?php $tasklistId = 0 ?>
	@else
		<?php $tasklistId = $para['tasklist'][$num]->tasklistId ?>
	@endif

	<div id='add_task' class='panel panel-primary b-form'>
		<div class='panel-heading'>
			<h5 class='panel-title heading'><i class='glyphicon glyphicon-edit'></i><span> {{Lang::get('caption.title.add_task')}}</span></h5>
		</div>				
		<div class='panel-body'>
			{{ Form::open(array(
				'id'			=> 'abc',
				'method' 		=> 'post',
				'route' 		=> 'add_task',
				'autocomplete'	=> 'off',
				'class'			=> 'form-horizontal',					
				'name'			=> 'task'))
			}}
			{{ Form::hidden('source','', array('class' => 'form-control', 'id' => 'Source'
			)) }}
			{{ Form::hidden('num',$num, array('class' => 'form-control txtNum'
			)) }}			 	
			{{ Form::hidden('tasklistId',$tasklistId, array('class' => 'form-control', 'id'=>'txtTaskListId'
			)) }}
			{{ Form::hidden('taskId',Input::old('taskId'), array('class' => 'form-control', 'id' => 'txtTaskId'
			)) }}
		 	<div class='input-group'>	
		 	 	<label class='control-label'>{{Lang::get('caption.label.add_task.lbtaskname')}} </label>	 	 	  
				<span class='place'>*</span></span>					
				{{ Form::text('taskname', Input::old('taskname')
					,array('class'  		=> 'col-md-5 form-control', 
						   'placeholder'	=> Lang::get('caption.label.add_task.taskname'), 'id'=>'txtTask')) 
				}}
			</div>
			<p class='error_msg'>
				@if($errors->has('taskname'))
					{{ $errors->get('taskname')[0];}}	
				@endif
			</p>

			<div class='input-group'>
				<label for='taskdescription' class='control-label'>{{Lang::get('caption.label.add_task.lbdesc')}} </label>
				<span class='place'>&nbsp;&nbsp;</span></span>
				{{ Form::textarea('desc', Input::old('desc'),
					array('class'	  		=> 'form-control', 
						  'placeholder'		=> Lang::get('caption.label.add_task.desc'), 'rows' => 3, 'id'=>'txtDesc')) 
				}}
			</div>		

			<div class='input-group'>
				<label class='control-label'>{{Lang::get('caption.label.add_task.lbassigned')}} </label>
				<span class='place'>&nbsp;&nbsp;</span></span>
				<select class='form-control' name='member' id='cboAssignTo'>
					<option>{{Lang::get('caption.label.add_task.assigned')}}</option>	
					@foreach($para['member'] as $member)
						@if(Session::hasOldInput('member'))
							@if(Input::old('member')==$member->memberId)								
								<option selected='true' value='{{$member->memberId}}'>{{ $member->member }}</option>								
							@else
								<option value='{{$member->memberId}}'>{{ $member->member }}</option>
							@endif
						@else				
						<option value='{{$member->memberId}}'>{{ $member->member }}</option>
						@endif
					@endforeach
				</select>
			</div>		

			<div class='input-group'>
				<label class='control-label'>{{Lang::get('caption.label.add_task.lbstart_date')}} </label>
				<span class='place'>*</span>
				  {{ Form::text('startDate', Input::old('startDate'),
				  		array('class'			  => 'form-control date_picker',
				  			  'data-date-format'  => 'dd-MM-yyyy', 
				  			  'placeholder'		  => Lang::get('caption.label.add_task.start_date'),
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
				<label class='control-label'>{{Lang::get('caption.label.add_task.lbdue_date')}} </label>
				<span class='place'>*</span>
				    {{ Form::text('dueDate',Input::old('dueDate'),
						array('class'			=> 'form-control date_picker', 
							  'data-date-format'	=> 'dd-MM-yyyy', 
							  'placeholder'		=> Lang::get('caption.label.add_task.due_date'),
							  'id'				=> 'DueDate', 'readonly'))
					}}
					<span class='input-group-addon'><i class='glyphicon glyphicon-calendar'></i></span>
			</div>
			<p class='error_msg' id='due_error'>
				@if($errors->has('dueDate'))
					{{ $errors->get('dueDate')[0];}}	
				@endif
			</p>

			<div class='input-group'>
				<label class='control-label'>{{Lang::get('caption.label.add_task.lbpriority')}} </label>
				<span class='place'>&nbsp;&nbsp;</span></span>
				<select class='form-control' name='priority' id='cboPriority'>
					@foreach($para['priority'] as $priority)
						@if(Session::hasOldInput('priority'))
							@if(Input::old('priority')==$priority->priorityId)								
								<option selected='true' value='{{$priority->priorityId}}'>{{ $priority->priority }}</option>
							@else
								<option value='{{$priority->priorityId}}'>{{ $priority->priority }}</option>
							@endif
						@else				
						<option value='{{$priority->priorityId}}'>{{ $priority->priority }}</option>
						@endif
					@endforeach
				</select>
			</div>	
			
			@if(isset($para['tasklist']))
				<div id='btn' class='col-md-12'>
					<p>
						{{ Form::button(Lang::get('caption.link.button.create'), array('class' => 'btn btn-default', 'id' => 'btnSubmit')) }}	
						{{ Form::button(Lang::get('caption.link.button.edit'), array('class' => 'btn btn-default hide', 'id' => 'btnEdit')) }}										
					</p>
			    </div>		    
			@endif
			{{ Form::close() }}	
		</div>	
	</div> 	
		
@show