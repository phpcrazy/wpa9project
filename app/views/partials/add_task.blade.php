@section('add_task')

@if(!isset($num))
	<?php $num = 0;	?>
@endif

	<div id="add_task" class="panel panel-primary b-form">
		<div class="panel-heading">
			<h5 class="panel-title heading"><i class='glyphicon glyphicon-edit'></i><span> Task Registration Form</span></h5>
		</div>				
		<div class="panel-body">
			{{ Form::open(array(
				'id'			=> 'abc',
				'method' 		=> 'post',
				'route' 		=> 'add_task',
				'autocomplete'	=> 'off',
				'class'			=> 'form-horizontal',					
				'name'			=> 'task'))
			}}
			{{ Form::hidden('source','', array("class" => 'form-control txtSource'
			)) }}
			{{ Form::hidden('num',$num, array("class" => 'form-control txtNum'
			)) }}			 	
			{{ Form::hidden('tasklistId',$para['tasklist'][$num]->tasklistId, array("class" => 'form-control', 'id'=>'txtTaskListId'
			)) }}
			{{ Form::hidden('taskId',Input::old('taskId'), array("class" => 'form-control', 'id' => 'txtTaskId'
			)) }}
		 	<div class="input-group">	
		 	 	<label class="control-label">Task Name </label>	 	 	  
				<span class='place'>*</span></span>					
				{{ Form::text('taskname', Input::old('taskname')
					,array("class"  		=> 'col-md-5 form-control', 
						   "placeholder"	=> 'Task Name', 'id'=>'txtTask')) 
				}}
			</div>
			<p class="error_msg">
				@if($errors->has('taskname'))
					@foreach($errors->get('taskname') as $name)
						{{ $name }}
					@endforeach
				@endif
			</p>

			<div class="input-group">
				<label for="taskdescription" class="control-label">Description </label>
				<span class='place'>&nbsp;&nbsp;</span></span>
				{{ Form::textarea('desc', Input::old('desc')
					,array("class"  		=> 'form-control', 
						   "placeholder"	=> 'Task Description', 'rows'=>"3", 'id'=>'txtDesc')) 
				}}
			</div>		

			<div class="input-group">
				<label class="control-label">Assigned to </label>
				<span class='place'>&nbsp;&nbsp;</span></span>
				<select class="form-control" name="member" id="cboAssignTo">
					<option>Please Choose</option>	
					@foreach($para['member'] as $member)
						@if(Session::hasOldInput('member'))
							@if(Input::old('member')==$member->memberId)								
								<option selected="true" value="{{$member->memberId}}">{{ $member->member }}</option>								
							@else
								<option value="{{$member->memberId}}">{{ $member->member }}</option>
							@endif
						@else				
						<option value="{{$member->memberId}}">{{ $member->member }}</option>
						@endif
					@endforeach
				</select>
			</div>		

			<div class="input-group">
				<label class="control-label">Start Date </label>
				<span class='place'>*</span>
				  {{ Form::text('startDate',Input::old('startDate'),
				  		array("class"=>'form-control date_picker',
				  			   "data-date-format"=>'dd-MM-yyyy', 
				  			   "placeholder"=>'Pick Start Date',
				  			   "id" => "StartDate", 'readonly'))
				  }}
				  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			</div>
			<p class="error_msg" id="startDate_error">
				@if($errors->has('startDate'))
					@foreach($errors->get('startDate') as $startDate_errors)
						{{ $startDate_errors }}
					@endforeach
				@endif
			</p>

			<div class="input-group">
				<label class="control-label">Due Date </label>
				<span class="place">*</span>
				    {{ Form::text('dueDate',Input::old('dueDate'),
							array("class"=>'form-control date_picker', 
							"data-date-format"=>'dd-MM-yyyy', 
							"placeholder"=>'Pick Due Date',
							"id"=>"DueDate", 'readonly'))
					}}
					<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			</div>
			<p class="error_msg" id="due_error">
				@if($errors->has('dueDate'))
					@foreach($errors->get('dueDate') as $due_errors)
						{{ $due_errors }}
					@endforeach
				@endif
			</p>

			<div class="input-group">
				<label class="control-label">Priority </label>
				<span class='place'>&nbsp;&nbsp;</span></span>
				<select class="form-control" name="priority" id="cboPriority">
					@foreach($para['priority'] as $priority)
						@if(Session::hasOldInput('priority'))
							@if(Input::old('priority')==$priority->priorityId)								
								<option selected="true" value="{{$priority->priorityId}}">{{ $priority->priority }}</option>
							@else
								<option value="{{$priority->priorityId}}">{{ $priority->priority }}</option>
							@endif
						@else				
						<option value="{{$priority->priorityId}}">{{ $priority->priority }}</option>
						@endif
					@endforeach
				</select>
			</div>	
				
			<div id="btn" class="col-md-12">
				<p>
					<input type="button" class="btn btn-default" value="Create" id="btnSubmit">
					<input type="button" class="btn btn-default hide" value="Edit" id="btnEdit">					
				</p>
		    </div>		    
			{{ Form::close() }}	
		</div>	
	</div> 
	
	<script>
		$(function() {
			$( ".date_picker").datepicker({
				showButtonPanel : true,
				autoclose		: true,
				startDate  		: "Today"
			})			
		});

		$('#add_task #btnSubmit').click(function(){
			if(ValidateDate()){
				document.task.submit();
			}
		});		

	</script>
		
@show