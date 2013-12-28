@section('add_project')

<div class="container">	
	<div id="add_project" class="col-md-4 col-md-offset-4 form_wrapper m-form">		
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		{{ Form::open(array(
			'method' 		=> 'post',
			'route'			=> 'add_project',
			'autocomplete'	=> 'off',	
			'class'			=> 'form-horizontal',
			'name'			=> 'project'
			))
		}}
		<h5 class="heading">Project Registration Form</h5>
		<div class="input-group">
			<span class='place'>*</span><span class="input-group-addon"><span class="glyphicon glyphicon-book"></span></span>					
				{{ Form::text('projectname', Input::old('projectname')
					,array("class"  		=> 'form-control', 
						   "placeholder"	=> 'Project Name')) 
				}}
		</div>
		<p class="error_msg">
			@if($errors->has('projectname'))
				@foreach($errors->get('projectname') as $projectname_errors)
					{{ $projectname_errors }}
				@endforeach
			@endif
		</p>		

		<div class="input-group">				
			<span class='place'>&nbsp;&nbsp;</span><span class="input-group-addon"><span class="glyphicon glyphicon-list"></span></span>
				{{ Form::text('desc', Input::old('desc')
					,array("class"  		=> 'form-control', 
						   "placeholder"	=> 'Project Description')) 
				}}
		</div>

		<div class="input-group">
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
					@foreach($errors->get('startDate') as $startdate_errors)
						{{ $startdate_errors }}
					@endforeach
			@endif
		</p>


		<div class="input-group">
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
				<span class='place'>&nbsp;&nbsp;</span></span>
				<select class="form-control" name="client">
					<option>Please Choose Client Name</option>
					@foreach($clients as $key=>$client)
						@if(Session::hasOldInput('client'))
							@if(Input::old('client')==$key)								
								<option selected="true" value="{{$key}}">{{ $client }}</option>								
							@else
								<option value="{{$key}}">{{ $client }}</option>
							@endif
						@else				
						<option value="{{$key}}">{{ $client }}</option>
						@endif
					@endforeach
				</select>
			</div>
		<script>
		    function  ValidateDate(){ 
				var str1 = $("#add_project #cboStartDate").val(); 
				var str2 = $("#add_project #cboDueDate").val();
				var dt1  = parseInt(str1.substring(0,2),10); 
				var mon1 = getMonthFromString(str1.substring(str1.indexOf('-')+1,str1.lastIndexOf('-'))); 
				var yr1  = parseInt(str1.substring(str1.lastIndexOf('-') + 1,str1.length),10);
				var dt2  = parseInt(str2.substring(0,2),10); 
				var mon2 = getMonthFromString(str2.substring(str2.indexOf('-')+1,str2.lastIndexOf('-'))); 
				var yr2  = parseInt(str2.substring(str2.lastIndexOf('-') + 1,str2.length),10);
				if(new Date(Date.parse(mon1 + " " + dt1 + ", " + yr1))>
					new Date(Date.parse(mon2 + " " + dt2 + ", " + yr2))){

					$("#add_project #due_error").text("Due Date should not be less than Start Date");
					$("#add_project #startDate_error").text("");

				}
				else{
					document.project.submit();
				}

			}	

			function getMonthFromString(mon){
			   	return new Date(Date.parse(mon +" 1, 2012")).getMonth()+1
			}

			$(document).ready( function() {             
			    $( "#addProject .date_picker").datepicker({
			        showButtonPanel : true,
			        autoclose       : true,
			        startDate       : "Today"
			    });
			});				
		</script>	

		<div id="btn" class="col-md-12">
			<p>
				{{ Form::button('Create', array('class'=>"btn btn-default", 'onclick'=>"ValidateDate()")) }}	
			</p>			
		</div>	

		{{ Form::close() }}
	</div>						

</div> <!--- end of container -->

@show
