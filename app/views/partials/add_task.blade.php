@section('add_task')

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
			{{ Form::hidden('tasklistId',$tasklists[0]->tasklistId, array("class" => 'form-control', 'id'=>'txtTaskListId'
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
					@foreach($members as $member)
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
				  			   "id" => "cboStartDate", 'readonly'))
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
							"id"=>"cboDueDate", 'readonly'))
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
					@foreach($prioritys as $priority)
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
					@if(Input::old('taskId')!='')
						<input type="button" class="btn btn-default hide" value="Create" onclick="ValidateDate()" id="btnSubmit">
					@elseif($tasklists[0]->status!="Cancel"&&$tasklists[0]->status!="Pending")
						<input type="button" class="btn btn-default" value="Create" onclick="ValidateDate()" id="btnSubmit">
					@endif
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
	   function  ValidateDate(evt){ 
			var str1 = $("#add_task #cboStartDate").val(); 
			var str2 = $("#add_task #cboDueDate").val();
			var dt1  = parseInt(str1.substring(0,2),10); 
			var mon1 = getMonthFromString(str1.substring(str1.indexOf('-')+1,str1.lastIndexOf('-'))); 
			var yr1  = parseInt(str1.substring(str1.lastIndexOf('-') + 1,str1.length),10);
			var dt2  = parseInt(str2.substring(0,2),10); 
			var mon2 = getMonthFromString(str2.substring(str1.indexOf('-')+1,str2.lastIndexOf('-'))); 
			var yr2  = parseInt(str2.substring(str2.lastIndexOf('-') + 1,str2.length),10);
			if(new Date(Date.parse(mon1 + " " + dt1 + ", " + yr1))>
				new Date(Date.parse(mon2 + " " + dt2 + ", " + yr2))){

				$("#add_task #due_error").text("Due Date should not be less than Start Date");
				$("#add_task #startDate_error").text("");
			}
			else{
				document.task.submit();
			}

		}
		function getMonthFromString(mon){
		   	return new Date(Date.parse(mon +" 1, 2012")).getMonth()+1
		}

	</script>
		
@show