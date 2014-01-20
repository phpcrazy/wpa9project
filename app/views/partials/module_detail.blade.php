@extends('layouts.base')

@section('body')
	@if($errors->has())
		<script>
			$(document).ready( function() {
		  		$("#btnAddTaskList").click();
			});						
		</script>
	@endif
	<div class="container" id="module_detail">
		@include('partials.topNav')		
		<div id="breadcrumb_wrapper" class="row text-right">
			<ol class="breadcrumb">
				<li><a href="{{route('home')}}">Home</a></li>				
				<li><a href="{{route('project_list')}}">Projects List</a></li>
				<?php $url = "?projectId=" . Session::get('projectId') ?>
				<li><a href="{{url('project_detail').$url}}">Project Detail</a></li>
				<li class="active">Module Detail</li>
			</ol>
		</div> <!-- end of breadcrumb_wrapper -->
		<div id="main_content_wrapper" class="row">
				@include('partials.sidebar')
			<div id="main_content" class="col-md-10">

				<div class="row">
					<div id="panel_wrapper" class="col-md-12">
					
						<div class="panel panel-primary">
						  	<div class="panel-heading">
						    	<h3 class="panel-title">{{Lang::get('caption.title.module_detail.main')}}</h3>
						  	</div>
						  	<div class="panel-body">
						  	<div id="moduleSection">
						  	{{ Form::open(array(
								'method'		=> 'post',
								'route'			=> 'module_update',
								'autocomplete'	=> 'off',
								'class'			=> 'form-horizontal'
								))
							}}		
							{{ Form::hidden('moduleId',$para['module']->moduleId, array("class" => 'form-control', 'id' => 'txtModuleId'
							)) }}
							{{ Form::hidden('key','', array("class" => 'form-control', 'id' => 'txtKey'
							)) }}	
							{{ Form::hidden('value','', array("class" => 'form-control', 'id' => 'txtValue'
							)) }}
							{{ Form::submit('Submit', array('class' => 'btn btn-default hide', 'id'=>'btnSubmit')) }}
							{{ Form::close() }}	 
						 	<h4>
					 			<span class="red_text lblHide">{{$para['module']->module}}</span>
								{{ Form::text('module', $para['module']->module, array("class" => 'form-control txtShow')) 
								}}
					 		</h4>
					 		<?php
								if($para['module']->desc==null)$desc = '&nbsp;';
								else $desc = $para['module']->desc;
							?>
						 	<p class="row"><span class="col-md-2 text-right"><strong>{{Lang::get('caption.label.detail.desc')}} : </strong></span><span class="col-md-10 text-left lblHide">{{$desc}}</span>						 	
						 	{{ Form::text('desc', $para['module']->desc, array("class" => 'form-control txtShow')) 
							}}
							</p>
						 		<?php 
									$sdate = date_create($para['module']->startDate);
									$sdate = $sdate->format('d-F-Y');
									$ddate = date_create($para['module']->dueDate);
									$ddate = $ddate->format('d-F-Y');									
								?>
							<p class="row"><span class="col-md-2 text-right"><strong>{{Lang::get('caption.label.detail.s_date')}} : </strong></span><span class="col-md-10 text-left lblHide">{{$sdate}}</span>
							{{ Form::text('startDate',$sdate,
						  		array("class"=>'form-control date_picker txtShow',
						  			   "data-date-format"=>'dd-MM-yyyy', 
						  			   "placeholder"=>'Pick Start Date',
						  			   "id" => "startDate", 'readonly'))
							}}
							</p>
							<p class="row"><span class="col-md-2 text-right"><strong>{{Lang::get('caption.label.detail.d_date')}} : </strong></span><span class="col-md-10 text-left lblHide">{{$ddate}}</span>
							{{ Form::text('dueDate',$ddate,
						  		array("class"=>'form-control date_picker txtShow',
						  			   "data-date-format"=>'dd-MM-yyyy', 
						  			   "placeholder"=>'Pick Due Date',
						  			   "id" => "dueDate", 'readonly'))
							}}
							</p>
							<p class="row"><span class="col-md-2 text-right"><strong>{{Lang::get('caption.label.detail.status')}} : </strong></span><span class="text-left lblStatus label">{{$para['module']->status}}</span></p>
							<?php
								 if($para['module']->progress==null) $progress = '0%';
								 else $progress = $para['module']->progress;
							?>
							<p class="row"><span class="col-md-2 text-right"><strong>{{Lang::get('caption.label.detail.progress')}} : </strong></span><span class="text-left">{{$progress}}</span></p>
							
							<h4 class="red_text">{{Lang::get('caption.title.module_detail.tasklist_area')}} on {{$para['module']->module}}</h4>
							</div>
							<div id="tasklistSection">			  											
		  						<table class="table table-hover">

									<thead>
										<tr>
											<th><i class="glyphicon glyphicon-list"></i> {{Lang::get('caption.label.detail.tasklist_name')}}</th>
											<th><i class="glyphicon glyphicon-calendar"></i> {{Lang::get('caption.label.detail.status')}}</th>
											<th><i class="glyphicon glyphicon-stats"></i> {{Lang::get('caption.label.detail.progress')}}</th>
											<th><i class="glyphicon glyphicon-wrench"></i> {{Lang::get('caption.label.detail.action')}}</th>
										</tr>
									</thead>
									<tbody>																
										@foreach($para['tasklist'] as $tasklist)
										<tr>											
											<?php
												$date = date_create($tasklist->dueDate);
												$date = $date->format('d-F-Y');
											?>
											{{ Form::hidden('tasklistId',$tasklist->tasklistId, array("class" => 'form-control tId'
											)) }}
											<td>
												<a class='btnTaskListDetail' href="{{route('tasklist_detail')}}">{{$tasklist->tasklist}}</a>													
											</td>
											<td>{{$date}}</td>
											<?php
												 if($tasklist->progress==null) $progress = '0%';
												 else $progress = $tasklist->progress;
											?>
											<td>{{$progress}}</td>
											<td class='buttonGroup'>
												@if(Session::get('memberId') == $para['module']->authorizedBy && $para['module']->status!="Cancel" && $para['module']->status!="Pending")
													<a class="btn btn-danger btn-sm btnTaskListDelete" data-content="delete tasklist" data-trigger="hover" data-toggle="popover" data-placement="top" >
														<span class="glyphicon glyphicon-trash"></span>												
													</a>
												@endif
											</td>												
										</tr>											
										@endforeach																					
									</tbody>
								</table>
							</div>
								@if(Session::get('memberId') == $para['module']->authorizedBy && $para['module']->status!="Cancel" && $para['module']->status!="Pending")
									<p><a class="btn btn-primary btn-sm" href="#addTasklist" data-toggle="modal" id="btnAddTaskList">+ {{Lang::get('caption.link.button.add_tasklist')}}</a></p>			 					
								@endif
							</div>
						</div> <!--- end of panel_wrapper -->
					</div>
				</div> <!-- end of main_content -->			
			</div> <!-- end of main_content_wrapper -->
		</div>
	</div> <!-- end of module_detail -->
<script>
	$(document).ready( function() {		
		var temp;
		$('#tasklistSection .buttonGroup a').popover('hide');
		var startDate = $('#moduleSection #startDate').val();
		var dueDate = $('#moduleSection #dueDate').val();	
		$('.txtShow').hide();

		$('.lblStatus').each(function(){
	        var status = $(this).text();
			var tmp = 'label-';
			if(status=='Just Start')tmp+='info';
			else if(status=='Progress')tmp+='success';
			else if(status=='Finish')tmp+='primary';
			else if(status=='Pending')tmp+='warning';
			else tmp+='danger';
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
			$('#moduleSection h4').css('border-bottom',0);
		});

		$('.txtShow').focus(function(){
			temp = $(this).val();
		});

		$('#moduleSection .date_picker').change(function(){
			if($(this).attr('name')=='startDate'){
				if($(this).val()!=startDate)
					moduleUpdate($(this));				
			}
			else{
				if($(this).val()!=dueDate)
					moduleUpdate($(this));				
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
				moduleUpdate($(this));		
			}
			
		});		

		$('.txtShow').keypress(function(e){
			var code = e.keyCode || e.which;
			if(code == 13)
				$(this).blur();			
		});		

		$('#btnAddTaskList').click(function(){
			$('#addTasklist #txtModuleId').val($('#moduleSection #txtModuleId').val());
		});

		$('.btnTaskListDelete').click(function(){
			var tr = $(this).closest('tr');
			$tasklistId = tr.find('.tId').val();			
			$('#confirm_tasklist_delete #txtModuleId').val($('#txtModuleId').val());
			$('#confirm_tasklist_delete #txtTaskListId').val($tasklistId);
			$('#confirm_tasklist_delete').modal('show');

		});

		$('#confirm_tasklist_delete #btnYes').click(function(){
			$('#confirm_tasklist_delete #btnSubmit').click();
		});

		$('#confirm_tasklist_delete #btnNo').click(function(){
			window.location.reload();
		});

		$('.btnTaskListDetail').click(function(){
			var tr = $(this).closest('tr');				
			$tasklistId = tr.find('.tId').val();
			var url = '/tasklist_detail?tasklistId=' + $tasklistId;
			$(this).attr('href', url);	
			$(this).click();
		});
	});
		
	function moduleUpdate($input){
		$('#moduleSection #txtKey').val($input.attr('name'));	
		$('#moduleSection #txtValue').val($input.val());
		$('#moduleSection #btnSubmit').click();							
	};
</script>

<div class="modal fade" id="addTasklist" role="dialog" aria-hidden="false" data-backdrop="static">
		@include('partials/add_tasklist')
</div>

<div class="modal fade" id="confirm_tasklist_delete" role="dialog" aria-hidden="false" data-backdrop="static">
		@include('partials/confirm_tasklist_delete')
</div>
@stop