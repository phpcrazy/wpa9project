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
								{{ Form::hidden('tasklistId',$para['tasklist'][0]->tasklistId, array("class" => 'form-control', 'id' => 'txtTaskListId'
								)) }}								
								{{ Form::hidden('key','', array("class" => 'form-control', 'id' => 'txtKey'
								)) }}	
								{{ Form::hidden('value','', array("class" => 'form-control', 'id' => 'txtValue'
								)) }}
								{{ Form::submit('Submit', array('class' => 'btn btn-default hide', 'id'=>'btnSubmit')) }}
								{{ Form::close() }}
						 		<h4>
						 			<span class="red_text lblHide">{{$para['tasklist'][0]->tasklist}}</span>
									{{ Form::text('tasklist', $para['tasklist'][0]->tasklist, array("class" => 'form-control txtShow')) 
									}}
						 		</h4>	
						 		<?php
								if($para['tasklist'][0]->desc==null)$desc='&nbsp;';
									else $desc=$para['tasklist'][0]->desc;
								?>						 			
						 		<p class="row"><span class="col-md-3 text-right"><strong>Descripion : </strong></span><span class="col-md-9 text-left lblHide">{{$desc}}</span>						 	
								 	{{ Form::text('desc', $para['tasklist'][0]->desc, array("class" => 'form-control txtShow')) 
									}}
								</p>
							 		<?php 
										$sdate = date_create($para['tasklist'][0]->startDate);
										$sdate = $sdate->format('d-F-Y');
										$ddate = date_create($para['tasklist'][0]->dueDate);
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
								<p class="row"><span class="col-md-3 text-right"><strong>Status : </strong></span><span class="text-left lblStatus label">{{$para['tasklist'][0]->status}}</span></p>
								<?php
									 if($para['tasklist'][0]->progress==null) $progress = '0%';
									 else $progress = $para['tasklist'][0]->progress;
								?>
								<p class="row"><span class="col-md-3 text-right"><strong>Progress : </strong></span><span class="text-left">{{$progress}}</span></p>	
								</div> <!--- end of tasklistSection -->
								<div class="task_detail">									
									<h4 class="red_text">Tasks on {{$para['tasklist'][0]->tasklist}}</h4>			  						
			  							@include('partials/task_detail')			  										
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

			if($('#add_task #btnSubmit').hasClass('hide')){
				$('#add_task #btnEdit').removeClass('hide');
			}						
		});
		
		function tasklistUpdate($input){
			$('#tasklistSection #txtKey').val($input.attr('name'));	
			$('#tasklistSection #txtValue').val($input.val());
			$('#tasklistSection #btnSubmit').click();							
		}

		
	</script>

<div class="modal fade" id="confirm_task_delete" role="dialog" aria-hidden="false" data-backdrop="static">
		@include('partials/confirm_task_delete')
</div>
@stop