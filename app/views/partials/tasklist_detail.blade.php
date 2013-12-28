@extends('layouts.base')

@section('body')
	<div class="container" id='tasklist_detail'>
		@include('partials.topNav')
		<div id="breadcrumb_wrapper" class="row text-right">
			<ol class="breadcrumb">
				<li><a href="{{route('home')}}">Home</a></li>				
				<li><a href="{{route('project_list')}}">Projects List</a></li>
				<?php $url = "?projectId=" . Session::get('projectId') ?>
				<li><a href="{{url('project_detail').$url}}">Project Detail</a></li>
				<?php $url = "?moduleId=" . Session::get('moduleId') ?>
				<li><a href="{{url('module_detail').$url}}">Module Detail</a></li>				
				<li class="active">Tasklist Detail</li>
			</ol>
		</div> <!-- end of breadcrumb_wrapper -->
		<div id="main_content_wrapper" class="row">
			@include('partials.sidebar')
			<div id="main_content" class="col-md-7">
				<div class="row">
					<div id="panel_wrapper" class="col-md-12">					
						<div class="panel panel-primary">
						  	<div class="panel-heading">
						    	<h3 class="panel-title">Tasklist Detail</h3>
						 	</div>
						 	<div class="panel-body">
						 		<div id="tasklistSection">
						 		{{ Form::open(array(
									'method'		=> 'post',
									'route'			=> 'tasklist_update',
									'autocomplete'	=> 'off',
									'class'			=> 'form-horizontal'
									))
								}}		
								{{ Form::hidden('tasklistId',$tasklists[0]->tasklistId, array("class" => 'form-control', 'id' => 'txtTaskListId'
								)) }}								
								{{ Form::hidden('key','', array("class" => 'form-control', 'id' => 'txtKey'
								)) }}	
								{{ Form::hidden('value','', array("class" => 'form-control', 'id' => 'txtValue'
								)) }}
								{{ Form::submit('Submit', array('class' => 'btn btn-default hide', 'id'=>'btnSubmit')) }}
								{{ Form::close() }}
						 		<h4>
						 			<span class="red_text lblHide">{{$tasklists[0]->tasklist}}</span>
									{{ Form::text('tasklist', $tasklists[0]->tasklist, array("class" => 'form-control txtShow')) 
									}}
						 		</h4>	
						 		<?php
								if($tasklists[0]->desc==null)$desc='&nbsp;';
									else $desc=$tasklists[0]->desc;
								?>						 			
						 		<p class="row"><span class="col-md-3 text-right"><strong>Descripion : </strong></span><span class="col-md-9 text-left lblHide">{{$desc}}</span>						 	
								 	{{ Form::text('desc', $tasklists[0]->desc, array("class" => 'form-control txtShow')) 
									}}
								</p>
							 		<?php 
										$sdate = date_create($tasklists[0]->startDate);
										$sdate = $sdate->format('d-F-Y');
										$ddate = date_create($tasklists[0]->dueDate);
										$ddate = $ddate->format('d-F-Y');									
									?>
								<p class="row">
									<span class="col-md-3 text-right"><strong>Started date : </strong></span><span class="col-md-9 text-left lblHide">{{$sdate}}</span>
									{{ Form::text('startDate',$sdate,
								  		array("class"=>'form-control date_picker txtShow',
								  			   "data-date-format"=>'dd-MM-yyyy', 
								  			   "placeholder"=>'Pick Start Date',
								  			   "id" => "startDate", 'readonly'))
									}}
								</p>
								<p class="row">
									<span class="col-md-3 text-right"><strong>Due date : </strong></span><span class="col-md-9 text-left lblHide">{{$ddate}}</span>
									{{ Form::text('startDate',$ddate,
								  		array("class"=>'form-control date_picker txtShow',
								  			   "data-date-format"=>'dd-MM-yyyy', 
								  			   "placeholder"=>'Pick due Date',
								  			   "id" => "dueDate", 'readonly'))
									}}
								</p>
								<p class="row"><span class="col-md-3 text-right"><strong>Status : </strong></span><span class="text-left lblStatus label">{{$tasklists[0]->status}}</span></p>
								<?php
									 if($tasklists[0]->progress==null) $progress = '0%';
									 else $progress = $tasklists[0]->progress;
								?>
								<p class="row"><span class="col-md-3 text-right"><strong>Progress : </strong></span><span class="text-left">{{$progress}}</span></p>	
								</div> <!--- end of tasklistSection -->
								<div id="taskSection">
									{{ Form::open(array(
										'method'		=> 'post',
										'route'			=> 'task_update',
										'autocomplete'	=> 'off',
										'class'			=> 'form-horizontal'
										))
									}}	
									{{ Form::hidden('tasklistId',$tasklists[0]->tasklistId, array("class" => 'form-control'
									)) }}	
									{{ Form::hidden('taskId',0, array("class" => 'form-control','id'=>'txtTaskId'
									)) }}
									{{ Form::hidden('taskname','status', array("class" => 'form-control', 'id'=>'txtTask'
									)) }}	
									{{ Form::hidden('desc',1, array("class" => 'form-control','id'=>'txtDesc'
									)) }}
									{{ Form::hidden('member',0, array("class" => 'form-control','id'=>'txtAssignTo'
									)) }}
									{{ Form::hidden('startDate','status', array("class" => 'form-control', 'id'=>'txtStartDate'
									)) }}	
									{{ Form::hidden('dueDate',1, array("class" => 'form-control','id'=>'txtDueDate'
									)) }}
									{{ Form::hidden('priority',1, array("class" => 'form-control','id'=>'txtPriority'
									)) }}
									{{ Form::submit('Submit', array('class' => 'btn btn-default hide', 'id'=>'btnSubmit')) }}
									{{ Form::close() }}
									<h4 class="red_text">Tasks on {{$tasklists[0]->tasklist}}</h4>
			  						<table class="table table-hover">
										<thead>
											<tr>
												<th><i class="glyphicon glyphicon-list"></i> 
												Task Name</th>
												<th><i class="glyphicon glyphicon-calendar"></i> Due Date </th>
												<!-- <th><i class="glyphicon glyphicon-user"></i> Assigned to</th> -->
												<th><i class="glyphicon glyphicon-sort-by-attributes"></i> Priority</th>
												<th><i class="glyphicon glyphicon-stats"></i> Status</th>
												<th><i class="glyphicon glyphicon-wrench"></i> Action</th>
											</tr>
										</thead>
										<tbody>					
										@foreach($tasks as $task)								
											<tr>
												<td class='tId hide'>{{$task->taskId}}</td>
												<?php 
													$sdate1 = date_create($task->startDate);
													$sdate1 = $sdate1->format('d-F-Y');
													$ddate1 = date_create($task->dueDate);
													$ddate1 = $ddate1->format('d-F-Y');									
												?>
												<td><a class="lkTask">{{$task->task}}</a></td>
												<td>{{$ddate1}}</td>
												<!-- <td>Member1</td> -->
												<td>{{$task->priority}}</td>
												<td><span class="lblStatus label">{{$task->status}}</span></td>					
												<td class='buttonGroup'>
													@if(Session::get('memberId')==$tasklists[0]->authorizedBy&&$tasklists[0]->status!="Cancel"&&$tasklists[0]->status!="Pending")
														<a class="btn btn-primary btn-sm btnTaskEdit" data-content="edit task" data-trigger="hover" data-toggle="popover" data-placement="top">
																<span class="glyphicon glyphicon-edit"></span>
															</a>
														<a class="btn btn-danger btn-sm btnTaskDelete" data-content="delete task" data-trigger="hover" data-toggle="popover" data-placement="top" >
															<span class="glyphicon glyphicon-trash"></span>					
														</a>
													@endif
												</td>											
											</tr>
											<tr class='trTaskDetail hide'>
												<td rowspan="2"><i class="glyphicon glyphicon-th-list"></i> <strong>Description :</strong></td>
												<td rowspan="2" colspan="2"><p class="lblDesc">{{$task->desc}}</p></td>
												<td><i class="glyphicon glyphicon-user"></i><strong> Assigned To :</strong></td>
												<td>{{$task->member}}</td>
											</tr>
											<tr class='trTaskDetail hide'>
												<td><i class="glyphicon glyphicon-calendar"></i><strong> Start Date :</strong></td>
												<td>{{$ddate1}}</td>
											</tr>
										@endforeach														
										</tbody>
									</table>									
								</div><!--- end of taskSection -->					 					
							</div>
						</div> <!--- end of panel_wrapper -->
					</div>
				</div>
			</div> <!-- end of main_content -->
			<div id="task_area" class="col-md-3">
				@include('partials/add_task')
			</div>			
		</div> <!-- end of main_content_wrapper -->
	</div>

	<script>
		$(document).ready( function() {		
			var temp;			
			var startDate = $('#tasklistSection #startDate').val();
			var dueDate = $('#tasklistSection #dueDate').val();	
			$('.txtShow').hide();
			$('#taskSection .buttonGroup a').popover('hide');

			$('.lblStatus').each(function(){
		        var status = $(this).text();
				var tmp = 'label-';
				if($('#tasklistSection .lblStatus').text()!='Cancel'&& $('#tasklistSection .lblStatus').text()!='Pending'){
					if(status=='Unchecked')tmp+='start';
					else if(status=='Checked')tmp+='default';
					else if(status=='Progress')tmp+='success';
					else if(status=='Just Start')tmp+='info';
					else if(status=='Complete')tmp+='info';
					else if(status=='Finish')tmp+='primary';
					else if(status=='Pending')tmp+='warning';
					else tmp+='danger';
					
				}
				else{
					if($('#tasklistSection .lblStatus').text()=='Pending')tmp+='warning';
					else tmp+='danger';
				}
				$(this).addClass(tmp);
				
			});
			
			$('.lblHide').click(function(){
				$('.lblHide').hide();
				$('.txtShow').show();
				if($(this).hasClass('red_text'))
					$tmp = $(this).closest('h4');
				else
					$tmp = $(this).closest('p');			
				$tmp.find('.txtShow').focus().select();			
				$('#tasklistSection h4').css('border-bottom',0);
			});

			$('.txtShow').focus(function(){
				temp = $(this).val();
			});

			$('#tasklistSection .date_picker').change(function(){
				if($(this).attr('name')=='startDate'){
					if($(this).val()!=startDate)
						tasklistUpdate($(this));				
				}
				else{
					if($(this).val()!=dueDate)
						tasklistUpdate($(this));				
				}				
			});

			$('.txtShow').blur(function(){
				$tmp = $(this).closest('p');
				$lbl = $tmp.find('strong').text();
				$lbl = $lbl.slice(0, $lbl.length-2);

				if($(this).val()==''){				
					alert($lbl + ' is empty!');
					location.reload();
				}
				else if(temp != $(this).val()){						
					tasklistUpdate($(this));		
				}
				
			});		

			$('.txtShow').keypress(function(e){
				var code = e.keyCode || e.which;
				if(code == 13)
					$(this).blur();							
			});

			$('.lkTask').click(function(){
				$('.trTaskDetail').addClass('hide');
				var tr = $(this).closest('tr');		
				tr.next('.trTaskDetail').removeClass('hide').next('.trTaskDetail').removeClass('hide');
			});

			$('.btnTaskDelete').click(function(){
				var tr = $(this).closest('tr');
				$taskId = tr.find('.tId').text();		
				$('#confirm_task_delete #txtTaskListId').val($('#txtTaskListId').val());
				$('#confirm_task_delete #txtTaskId').val($taskId);
				$('#confirm_task_delete').modal('show');

			});

			$('#confirm_task_delete #btnYes').click(function(){
				$('#confirm_task_delete #btnSubmit').click();
			});

			$('#confirm_task_delete #btnNo').click(function(){
				window.location.reload();
			});

			if($('#add_task #btnSubmit').hasClass('hide')){
				$('#add_task #btnEdit').removeClass('hide');
			}

			$('.btnTaskEdit').click(function(){
				var tr = $(this).closest('tr');
				$('#add_task #txtTaskId').val(tr.find('.tId').text());
				$('#add_task #txtTask').val(tr.find('td:eq(1) a').text());
				$('#add_task #txtDesc').val(tr.next('.trTaskDetail').find('td:eq(1) p').text());
				var selector = '#add_task #cboAssignTo option:contains("' + tr.next('.trTaskDetail').find('td:eq(3)').text() + '")';
				var value = $(selector).val();
				$('#add_task #cboAssignTo').val(value);
				$('#add_task #cboStartDate').val(tr.next('.trTaskDetail').next('.trTaskDetail').find('td:eq(1)').text());
				$('#add_task #cboDueDate').val(tr.find("td:eq(2)").text());
				selector = '#add_task #cboPriority option:contains("' + tr.find("td:eq(3)").text() + '")';
				value = $(selector).val();
				$('#add_task #cboPriority').val(value);
				$('#add_task #btnSubmit').addClass('hide');
				$('#add_task #btnEdit').removeClass('hide');
				$('#add_task .heading span').text(' Task Edit Form');
			});

			$('#add_task #btnEdit').click(function(){
				if(ValidateDate1()){
					$('#taskSection #txtTaskId').val($('#add_task #txtTaskId').val());
					$('#taskSection #txtTask').val($('#add_task #txtTask').val());
					$('#taskSection #txtDesc').val($('#add_task #txtDesc').val());
					$('#taskSection #txtStartDate').val($('#add_task #cboStartDate').val());
					$('#taskSection #txtDueDate').val($('#add_task #cboDueDate').val());
					$('#taskSection #txtAssignTo').val($('#add_task #cboAssignTo option:selected').val());
					$('#taskSection #txtPriority').val($('#add_task #cboPriority option:selected').val());
					$('#taskSection #btnSubmit').click();
				}
			});
		});
		
		function tasklistUpdate($input){
			$('#tasklistSection #txtKey').val($input.attr('name'));	
			$('#tasklistSection #txtValue').val($input.val());
			$('#tasklistSection #btnSubmit').click();							
		}

		function  ValidateDate1(){ 
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
				return false;
			}
			else{
				return true;
			}

		}
	</script>

<div class="modal fade" id="confirm_task_delete" role="dialog" aria-hidden="false" data-backdrop="static">
		@include('partials/confirm_task_delete')
</div>
@stop