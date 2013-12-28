@section('add_module')
		<div class="container">
			<div id="add_module" class="col-md-4 col-md-offset-4 form_wrapper m-form">		
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>	
				{{ Form::open(array(
					'method' 		=> 'post',
					'route' 		=> 'add_module',
					'autocomplete'	=> 'off',
					'class'			=> 'form-horizontal',					
					'name'			=> 'module'))
				}}
				<h5 class="heading">Module Registration Form</h5>			 	
			 	<div class="input-group">		 	 	  
					<span class='place'>*</span><span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>					
					{{ Form::hidden('projectId',0, array("class" => 'form-control', 'id' => 'txtProjectId'
					)) }}
					{{ Form::text('modulename', Input::old('modulename')
						,array("class"  		=> 'form-control', 
							   "placeholder"	=> 'Module Name')) 
					}}
				</div>
				<p class="error_msg">
					@if($errors->has('modulename'))
						@foreach($errors->get('modulename') as $name)
							{{ $name }}
						@endforeach
					@endif
				</p>

				<div class="input-group">
					<span class='place'>&nbsp;&nbsp;</span><span class="input-group-addon"><span class="glyphicon glyphicon-list"></span></span>
					{{ Form::text('desc', Input::old('desc')
						,array("class"  		=> 'form-control', 
							   "placeholder"	=> 'Module Description')) 
					}}
				</div>		

				<div class="input-group">
					  <span class='place'>*</span>
					  {{ Form::text('startDate',Input::old('startDate'),
					  		array("class"=>'form-control date_picker',
					  			   "data-date-format"=>'dd-MM-yyyy', 
					  			   "placeholder"=>'Pick Start Date',
					  			   "id"=>"cboStartDate", 'readonly'))
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
				<script>
				    function  ValidateDate(){ 
						var str1 = $("#add_module #cboStartDate").val(); 
						var str2 = $("#add_module #cboDueDate").val();
						var dt1  = parseInt(str1.substring(0,2),10); 
						var mon1 = getMonthFromString(str1.substring(str1.indexOf('-')+1,str1.lastIndexOf('-'))); 
						var yr1  = parseInt(str1.substring(str1.lastIndexOf('-') + 1,str1.length),10);
						var dt2  = parseInt(str2.substring(0,2),10); 
						var mon2 = getMonthFromString(str2.substring(str2.indexOf('-')+1,str2.lastIndexOf('-'))); 
						var yr2  = parseInt(str2.substring(str2.lastIndexOf('-') + 1,str2.length),10);
						if(new Date(Date.parse(mon1 + " " + dt1 + ", " + yr1))>
							new Date(Date.parse(mon2 + " " + dt2 + ", " + yr2))){
							
							$("#add_module #due_error").text("Due Date should not be less than Start Date");
							$("#add_module #startDate_error").text("");
						}
						else{
							document.module.submit();
						}

					}
					function getMonthFromString(mon){
					   	return new Date(Date.parse(mon +" 1, 2012")).getMonth()+1
					}
				
				</script>					 
				<div id="btn" class="col-md-12">		    	
					<p>
						<input type="button" class="btn btn-default" value="Create" onclick="ValidateDate()">
					</p>
			    </div>		    
			{{Form::close()}}
		</div> <!--- end of form_wrapper  -->
	</div>
	<script>
		$(function() {
			$( ".date_picker").datepicker({
				showButtonPanel : true,
				autoclose		: true,
				startDate  		: "Today"
			})			
		});
	</script>
		
@show