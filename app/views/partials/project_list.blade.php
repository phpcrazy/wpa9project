@extends('layouts.base')

@section('body')

<div class="container" id="project_list">
		@include('partials.topNav')	
		<div id="breadcrumb_wrapper" class="row text-right">
			<ol class="breadcrumb">
				<li><a href="{{route('home')}}">Home</a></li>				
				<li class="active">Projects List</li>
			</ol>
		</div> <!-- end of breadcrumb_wrapper -->
		<div id="main_content_wrapper" class="row">
				@include('partials.sidebar')
			<div id="main_content" class="col-md-10">
				<div class="row">
					<div id="panel_wrapper" class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<span class="hide">Projects</span>
								<h3 class="panel-title">{{Lang::get('caption.title.project_list')}} in {{ $para['org'] }}</h3>
							</div>
							<div class="panel-body">
							{{ Form::open(array(
								'method'		=> 'post',
								'route'			=> 'project_update',
								'autocomplete'	=> 'off',
								'class'			=> 'form-horizontal'
								))
							}}
							{{ Form::hidden('projectId',0, array("class" => 'form-control', 'id' => 'txtProjectId'
							)) }}
							{{ Form::hidden('key','', array("class" => 'form-control', 'id' => 'txtKey'
							)) }}	
							{{ Form::hidden('value','', array("class" => 'form-control', 'id' => 'txtValue'
							)) }}							
							{{ Form::submit('Submit', array('class' => 'btn btn-default', 'id'=>'btnSubmit')) }}
							{{ Form::close() }}
							<?php $k = 0;?>
							@for($i=count($para['project']);$i>=1;$i=$i-2)								
								<div class="row proj_line">
								@for($j=0;$j<=1;$j++)																								
									<div class="col-md-6 proj_block">									
										<h4>
										<a class="btnProjectDetail lblhide" href="{{route('project_detail')}}">{{$para['project'][$k]->project}}</a>
										{{ Form::text('project', $para['project'][$k]->project, array("class" => 'col-md-2 form-control txtShow')) 
										}}
										&nbsp;&nbsp;-&nbsp;&nbsp;
										{{ Form::hidden('pid', $para['project'][$k]->projectId, array("class" => 'pId'
										)) }}
										<select class="form-control cboClient" name="client">
											<option>Please Choose</option>
											@foreach($para['client'] as $client)
												@if($para['project'][$k]->client==$client->client)						
													<option selected="true" value="{{ $client->clientId }}" disabled="true">{{ $client->client }}</option>		
												@else
													<option value="{{ $client->clientId }}">{{ $client->client }}</option>
												@endif
											@endforeach
										</select>
										<?php 
											$sdate = date_create($para['project'][0]->startDate);
											$sdate = $sdate->format('d-M-Y');
											$ddate = date_create($para['project'][0]->dueDate);
											$ddate = $ddate->format('d-M-Y');
										?>
										<span class="hidClient">{{$para['project'][$k]->client}}</span></h4>
										<p><strong>{{Lang::get('caption.label.detail.desc')}} : </strong>{{$para['project'][$k]->desc}}</p>
										<p><strong>{{Lang::get('caption.label.detail.s_date')}} : </strong>{{$sdate}}</p>
										<p><strong>{{Lang::get('caption.label.detail.d_date')}} : </strong>{{$ddate}}</p>
										<p><strong>{{Lang::get('caption.label.detail.a_by')}} : </strong>
										&nbsp;<select class="form-control cboMember" name="member">
											@foreach($para['member'] as $member)
												@if($para['project'][$k]->member==$member->member)						
													<option selected="true" value="{{ $member->memberId }}" disabled="true">{{ $member->member }}</option>		
												@else
													<option value="{{ $member->memberId }}">{{ $member->member }}</option>
												@endif
											@endforeach
										</select>
										<span class="lblMember">{{$para['project'][$k]->member}}</span></p>
										<p><strong>{{Lang::get('caption.label.detail.status')}} : </strong> <span class="lblStatus label">{{$para['project'][$k]->status}}</span></p>
										<?php
											 if($para['project'][$k]->progress==null) $progress = '0%';
											 else $progress = $para['project'][$k]->progress;
										?>
										<p><strong>{{Lang::get('caption.label.detail.progress')}} : </strong>{{$progress}}</p>
										@if($para['project'][$k]->status=="Finish")						
											<?php $tmp = Lang::get('caption.link.link.archieve'); $btn = 'btnArchieve';?>
										@elseif($para['project'][$k]->status != "Cancel")
											<?php $tmp = Lang::get('caption.link.link.delete'); $btn = 'btnDelete';?>
										@else
											<?php $tmp = ''; $btn = '';?>
										
										@endif
										<div class='proj_options'>											
											@if(Session::get('member') == $para['project'][$k]->member)
												<a class="btnRename">{{Lang::get('caption.link.link.rename')}} </a>
												@if(Session::get('role')==1 && $btn != '')		
													<a class="{{$btn}}">{{$tmp}} </a>
												@endif
												@if($para['project'][$k]->status!="Finish" && $para['project'][$k]->status!="Cancel" && $para['project'][$k]->status!="Pending")
													<a class="btnDeactivate">{{Lang::get('caption.link.link.deactivate')}} </a>
													<a class="btnAuthorityChange">{{Lang::get('caption.link.link.delegate')}} </a>
												@elseif($para['project'][$k]->status=="Pending")
													<a class="btnActivate">{{Lang::get('caption.link.link.activate')}} </a>
												@endif
												<a class="btnClientChange">
												@if($para['project'][$k]->client==Null)
													{{Lang::get('caption.link.link.add_client')}} 
												@else
													{{Lang::get('caption.link.link.ch_client')}}
												@endif			
												</a>																													
											@else
												@if(Session::get('role')==1 && $btn != '')		
													<a class="{{$btn}}">{{$tmp}} </a>
												@endif
											@endif
										</div>
									</div>
									<?php $k++;
										if($k==count($para['project']))break; 
									?>
								@endfor								
								</div>
							@endfor		
							</div>
						</div>
					</div> <!--- end of panel_wrapper -->					
				</div>
			</div> <!-- end of main_content -->
		</div> <!-- end of main_content_wrapper -->
	</div>

<script>
	$(document).ready( function() {	
		var temp;		
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

		$('.cboClient, .cboMember').hide();
		$('#btnSubmit').hide();	
		$('#confirm_project_authority_change #btnSubmit, #confirm_project_deactivate #btnSubmit, #confirm_project_delete #btnSubmit').hide();	

		$('.btnRename').click(function(){			
			temp = $(this).closest('.proj_block');
			$('#confirm_project_rename').modal('show');							
		});

		$('#confirm_project_rename #btnYes').click(function(){	
			$('#confirm_project_rename').modal('hide');					
			$('.lblhide').hide();
			$('.txtShow').show();
			temp.find('h4').css('border-bottom','0');
			temp.find('.txtShow').focus().select();	
		});

		$('.txtShow').focus(function(){
			temp = $(this).val();
		});

		$('.txtShow').blur(function(){
			var tmp = $(this).closest('.proj_block');
			if($(this).val()==''){				
				alert('Project Name should not be empty!');
				location.reload();
			}		
			else if($(this).val()!=temp){
				$('#txtKey').val('project');	
				$('#txtValue').val($(this).val());
				$('#txtProjectId').val(tmp.find('.pId').val());
				$('#btnSubmit').click();						
			}
		});

		$('.txtShow').keypress(function(e){
			var code = e.keyCode || e.which;
			if(code == 13){
				$(this).blur();
			}
		});

		$('.btnClientChange').click(function(){
			$('.cboClient').hide();
			$('.hidClient').show();
			var tmp = $(this).closest('.proj_block');
			tmp.find('.hidClient').hide();
			tmp.find('.cboClient').show();				
			$('#txtProjectId').val(tmp.find('.pId').val());			
		});

		$('.cboClient').change(function() {
			var tmp = $(this).closest('.proj_block');		
			if(tmp.find($('.cboClient option:selected')).val()!="Please Choose"){
				$('#txtValue').val(tmp.find($('.cboClient option:selected')).val());
				$('#txtKey').val('clientId');
				$('#btnSubmit').click();
			}
		});

		$('.btnAuthorityChange').click(function(){
			temp = $(this).closest('.proj_block');
			$('.cboMember').hide();
			$('.lblMember').show();	
			$('#confirm_project_authority_change').modal('show');	
		});

		$('#confirm_project_authority_change #btnYes').click(function(){			
			temp.find('.lblMember').hide();
			temp.find('.cboMember').show();			
			$('#confirm_project_authority_change').modal('hide');	
		});

		$('.cboMember').change(function() {
			var tmp = $(this).closest('.proj_block');	
			$('#txtProjectId').val(tmp.find('.pId').val());		
			$('#txtValue').val(tmp.find($('.cboMember option:selected')).val());
			$('#txtKey').val('authorizedBy');
			$('#btnSubmit').click();		
		});

		$('.btnDeactivate').click(function(){
			var tmp = $(this).closest('.proj_block');	
			$('#confirm_project_deactivate #txtprojectId').val(tmp.find('.pId').val());
			$('#confirm_project_deactivate').modal('show');	
		});

		$('#confirm_project_deactivate #btnYes').click(function(){
			$('#confirm_project_deactivate').modal('hide');	
			$('#confirm_project_deactivate #btnSubmit').click();	
		});

		$('.btnDelete').click(function(){
			var tmp = $(this).closest('.proj_block');	
			$('#confirm_project_delete #txtprojectId').val(tmp.find('.pId').val());
			$('#confirm_project_delete').modal('show');	
		});

		$('#confirm_project_delete #btnYes').click(function(){
			$('#confirm_project_delete').modal('hide');	
			$('#confirm_project_delete #btnSubmit').click();	
		});

		$('#confirm_project_rename #btnNo, #confirm_project_authority_change #btnNo, #confirm_project_deactivate #btnNo, #confirm_project_delete #btnNo').click(function(){
			location.reload();
		});	

		$('.btnProjectDetail').click(function(){
			var tmp = $(this).closest('.proj_block');				
			$projectId = tmp.find('.pId').val();
			var url = '/project_detail?projectId=' + $projectId;
			$(this).attr('href', url);	
			$(this).click();
		});
	});
</script>

<div class="modal fade" id="confirm_project_rename" role="dialog" aria-hidden="false" data-backdrop="static">
		@include('partials/confirm_project_rename')
</div>

<div class="modal fade" id="confirm_project_authority_change" role="dialog" aria-hidden="false" data-backdrop="static">
		@include('partials/confirm_project_authority_change')
</div>

<div class="modal fade" id="confirm_project_deactivate" role="dialog" aria-hidden="false" data-backdrop="static">
		@include('partials/confirm_project_deactivate')
</div>

<div class="modal fade" id="confirm_project_delete" role="dialog" aria-hidden="false" data-backdrop="static">
		@include('partials/confirm_project_delete')
</div>

@stop