@extends('layouts.base')

@section('body')
	@if($errors->has())
		<script>
			$(document).ready( function() {
		  		$("#btnAddModule").click();
			});						
		</script>
	@endif
	<div class="container" id="project_detail">
		@include('partials.topNav')		
		<div id="breadcrumb_wrapper" class="row text-right">
			<ol class="breadcrumb">
				<li><a href="{{route('home')}}">Home</a></li>				
				<li><a href="{{route('project_list')}}">Projects List</a></li>
				<li class="active">Project Detail</li>
			</ol>
		</div> <!-- end of breadcrumb_wrapper -->
		<div id="main_content_wrapper" class="row">
				@include('partials.sidebar')
			<div id="main_content" class="col-md-10">
				<div class="row">
					<div id="panel_wrapper" class="col-md-12">					
						<div class="panel panel-primary">
						  <div class="panel-heading">
						    <h3 class="panel-title">{{Lang::get('caption.title.project_detail.main')}}</h3>
						  </div>
						  <div class="panel-body">
						  <div id='projectSection'>
						  	{{ Form::open(array(
								'method'		=> 'post',
								'route'			=> 'project_update',
								'autocomplete'	=> 'off',
								'class'			=> 'form-horizontal'
								))
							}}		
							{{ Form::hidden('projectId',$para['project']->projectId, array("class" => 'form-control', 'id' => 'txtProjectId'
							)) }}
							{{ Form::hidden('key','', array("class" => 'form-control', 'id' => 'txtKey'
							)) }}	
							{{ Form::hidden('value','', array("class" => 'form-control', 'id' => 'txtValue'
							)) }}
							{{ Form::submit('Submit', array('class' => 'btn btn-default hide', 'id'=>'btnSubmit')) }}
							{{ Form::close() }}	 
						 	<h4><span  class="red_text">{{$para['project']->project}}</span> - {{$para['project']->client}}</h4>	
						 	<?php
								if($para['project']->desc == null)$desc='&nbsp;';
								else $desc = $para['project']->desc;
							?>
						 	<p class="row"><span class="col-md-2 text-right"><strong>{{Lang::get('caption.label.detail.desc')}} : </strong></span><span class="col-md-10 text-left lblHide">{{$desc}}</span>						 	
						 	{{ Form::text('desc', $para['project']->desc, array("class" => 'form-control txtShow')) 
							}}
							</p>
						 		<?php 
									$sdate = date_create($para['project']->startDate);
									$sdate = $sdate->format('d-F-Y');
									$ddate = date_create($para['project']->dueDate);
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
								<p class="row"><span class="col-md-2 text-right"><strong>{{Lang::get('caption.label.detail.a_by')}} : </strong></span>{{$para['project']->member}}</p>
								<p class="row"><span class="col-md-2 text-right"><strong>{{Lang::get('caption.label.detail.status')}} : </strong></span><span class="text-left lblStatus label">{{$para['project']->status}}</span></p>
								<?php
									 if($para['project']->progress == null) $progress = '0%';
									 else $progress = $para['project']->progress;
								?>
								<p class="row"	><span class="col-md-2 text-right"><strong>{{Lang::get('caption.label.detail.progress')}} : </strong></span><span class="text-left">{{$progress}}</span></p>
								</div>
								<div id="moduleSection">
								<h4 class="red_text">{{Lang::get('caption.title.project_detail.module_area')}} on {{$para['project']->project}}</h4>
			  						{{ Form::open(array(
										'method'		=> 'post',
										'route'			=> 'module_update',
										'autocomplete'	=> 'off',
										'class'			=> 'form-horizontal'
										))
									}}		
									{{ Form::hidden('projectId',$para['project']->projectId, array("class" => 'form-control'
									)) }}
									{{ Form::hidden('moduleId',0, array("class" => 'form-control','id'=>'txtModuleId'
									)) }}
									{{ Form::hidden('key','active', array("class" => 'form-control'
									)) }}	
									{{ Form::hidden('value',1, array("class" => 'form-control'
									)) }}						
			  						<table class="table table-hover">
										<thead>
											<tr>
												<th><i class="glyphicon glyphicon-list"></i> {{Lang::get('caption.label.detail.mod_name')}}</th>
												<th><i class="glyphicon glyphicon-calendar"></i> {{Lang::get('caption.label.detail.d_date')}}</th>
												<th><i class="glyphicon glyphicon-stats"></i> {{Lang::get('caption.label.detail.progress')}}</th>
												<th><i class="glyphicon glyphicon-wrench"></i> {{Lang::get('caption.label.detail.action')}}</th>
											</tr>
										</thead>
										<tbody>
																
											@foreach($para['module'] as $module)
											<tr>											
												<?php
													$date = date_create($module->dueDate);
													$date = $date->format('d-F-Y');
												?>												
												<td>
													{{ Form::hidden('mId',$module->moduleId, array("class" => 'form-control mId'
													)) }}
													<a class="btnModuleDetail" href="{{route('module_detail')}}">{{$module->module}}</a>
													@if($module->active==1)
													&nbsp;&nbsp;<span class='label label-success'>Active</span>
													@endif
												</td>
												<td>{{$date}}</td>
												<?php
													 if($module->progress==null) $progress = '0%';
													 else $progress = $module->progress;
												?>
												<td>{{$progress}}</td>
												<td class='buttonGroup'>
													@if(Session::get('member') == $para['project']->member && $para['project']->status!="Cancel" && $para['project']->status!="Pending")
														@if($module->active==0)
															<a class="btn btn-primary btn-sm btnModuleActive" data-content="make active module" data-trigger="hover" data-toggle="popover" data-placement="top">
																<span class="glyphicon glyphicon-edit"></span>
															</a>
														@endif
														<a class="btn btn-danger btn-sm btnModuleDelete" data-content="delete module" data-trigger="hover" data-toggle="popover" data-placement="top" >
															<span class="glyphicon glyphicon-trash"></span>												
														</a>
													@endif
												</td>												
											</tr>											
											@endforeach																					
										</tbody>
								</table>
								{{ Form::submit('Submit', array('class' => 'btn btn-default hide', 'id'=>'btnSubmit')) }}
								{{ Form::close() }}									
								@if(Session::get('member') == $para['project']->member && $para['project']->status!="Cancel" && $para['project']->status!="Pending")
									<p><a class="btn btn-primary btn-sm" href="#addModule" data-toggle="modal" id="btnAddModule">+ {{Lang::get('caption.link.button.add_mod')}}</a></p>
								@endif
								</div>
								<div id="eventSection">				 						
								@include('partials/event')							
							</div>
						</div> <!--- end of panel_wrapper -->
					</div>
				</div> <!-- end of main_content -->			
			</div> <!-- end of main_content_wrapper -->
		</div>
	</div> <!-- end of project_detail -->
<script>
	$(document).ready( function() {		
		var temp;
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

		$('#moduleSection .buttonGroup a').popover('hide');
		
		var startDate = $('#projectSection #startDate').val();
		var dueDate = $('#projectSection #dueDate').val();	
		$('#projectSection .txtShow').hide();

		$('#projectSection .lblHide').click(function(){
			$('#projectSection .lblHide').hide();
			$('#projectSection .txtShow').show();
			$tmp = $(this).closest('p');
			$tmp.find('.txtShow').focus().select();			
		});

		$('#projectSection .txtShow').focus(function(){
			temp = $(this).val();
		});

		$('#projectSection .date_picker').change(function(){
			if($(this).attr('name')=='startDate'){
				if($(this).val()!=startDate){
					projectUpdate($(this));
				}
			}
			else{
				if($(this).val()!=dueDate){
					projectUpdate($(this));
				}
			}				
		});

		$('#projectSection .txtShow').blur(function(){
			$tmp = $(this).closest('p');
			$lbl = $tmp.find('strong').text();
			$lbl = $lbl.slice(0, $lbl.length-2);
			
			if($(this).val()==''){				
				alert($lbl + ' is empty!');
				location.reload();
			}
			else if(temp != $(this).val()){	
				projectUpdate($(this));		
			}
			
		});		

		$('#project_detail .txtShow').keypress(function(e){
			var code = e.keyCode || e.which;
			if(code == 13){
				$(this).blur();
			}
		});

		$('#btnAddModule').click(function(){
			$('#addModule #txtProjectId').val($('#project_detail #txtProjectId').val());
		});

		$('.btnModuleActive').click(function(){
			var tr = $(this).closest('tr');				
			$moduleId = tr.find('.mId').val();			
			$('#txtModuleId').val($moduleId);
			$('#moduleSection #btnSubmit').click();
		});

		$('.btnModuleDelete').click(function(){
			var tr = $(this).closest('tr');
			$moduleId = tr.find('.mId').val();			
			$('#confirm_module_delete #txtProjectId').val($('#txtProjectId').val());
			$('#confirm_module_delete #txtModuleId').val($moduleId);
			$('#confirm_module_delete').modal('show');

		});

		$('#confirm_module_delete #btnYes').click(function(){
			$('#confirm_module_delete #btnSubmit').click();
		})

		$('#confirm_module_delete #btnNo').click(function(){
			window.location.reload();
		});	

		$('.btnModuleDetail').click(function(){
			var tr = $(this).closest('tr');				
			var moduleId = tr.find('.mId').val();
			var url = '/module_detail?moduleId=' + moduleId;
			$(this).attr('href', url);	
			$(this).click();
		});
		var projectId = $('#txtProjectId').val();		
	});
		
	function projectUpdate($input){
		$('#projectSection #txtKey').val($input.attr('name'));	
		$('#projectSection #txtValue').val($input.val());
		$('#projectSection #btnSubmit').click();							
	};
</script>

<div class="modal fade" id="addModule" role="dialog" aria-hidden="false" data-backdrop="static">
		@include('partials/add_module')
</div>

<div class="modal fade" id="confirm_module_delete" role="dialog" aria-hidden="false" data-backdrop="static">
		@include('partials/confirm_module_delete')
</div>
@stop