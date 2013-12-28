@extends('layouts.base')

@section('body')
	@if($errors->has())
		<script>
			$(document).ready( function() {
		  		$("#add_member").click();
			});						
		</script>
	@endif
	<div class="container" id="member_list">
		@include('partials/topNav')		
		<div id="breadcrumb_wrapper" class="row text-right">
			<ol class="breadcrumb">
				<li><a href="{{route('home')}}">Home</a></li>				
				<li class="active">Members List</li>
			</ol>
		</div> <!-- end of breadcrumb_wrapper -->
		<div id="main_content_wrapper" class="row">			
			@include('partials/sidebar')												
				<div id="main_content" class="col-md-10">
					<div class="row">
						<div id="panel_wrapper" class="col-md-12">					
							<div class="panel panel-primary">
							  	<div class="panel-heading">
							    	<h3 class="panel-title">Member List</h3>
							  	</div>
							  	<div class="panel-body">
					  				<div class="row">
						  				<div class="col-md-3 col-md-offset-9">
					  						<select class="form-control" id="change_view">
												<option selected="true">All</option>
												<option>Only Member</option>					
											</select>
					  					</div>
					  				</div>
					  			{{ Form::open(array(
									'method'		=> 'post',
									'route'			=> 'member_role_change',
									'autocomplete'	=> 'off',
									'class'			=> 'form-horizontal'
									))
								}}
								{{ Form::hidden('memberId',0, array("class" => 'form-control', 'id' => 'txtMemberId'
								)) }}
								{{ Form::hidden('pm_role_change','false', array("class" => 'form-control', 'id' => 'pm_role_change'
								)) }}	
								{{ Form::hidden('role',0, array("class" => 'form-control', 'id' => 'txtRole'
								)) }}						
								{{ Form::submit('Submit', array('class' => 'btn btn-default', 'id'=>'btnSubmit')) }}
								{{ Form::close() }}
		  						<table class="table table-hover">
									<thead>
										<tr>
											<th><i class="glyphicon glyphicon-user"></i> Member Name</th>
											<th><i class="glyphicon glyphicon-tasks"></i> Status </th>
											<th>
											@if(Session::get('role')==1)
											<i class="glyphicon glyphicon-wrench"></i> Action
											@endif
											</th>	
										</tr>
									</thead>

									<tbody>
									@foreach($members as $member)
											
										@if($member->role!='Member')
											<tr class="tr_hide">
										@else
											<tr>
										@endif
										
										
											@if(Session::get('role')==1)
												<td class="col-md-4">
											@else
												<td class="col-md-5">
											@endif
											@if($member->loginStatus=='true')
												<i class="glyphicon glyphicon-record green_text"></i> 
											@else
												<span class="place">&nbsp;&nbsp;&nbsp;</span>
											@endif											
											{{ Form::hidden('memberId',$member->memberId, array("class" => 'form-control memId'
											)) }}											
											<a class="btnMemberDetail"  href="{{route('member_detail')}}">{{$member->member}}</a>
												
											</td>
											<td class="col-md-4">
												<div class="col-md-6 mem_role">
													<select class="form-control cbo_role" name="role">
														@foreach($roles as $role)
															@if($member->role==$role['role'])						
																<option selected="true" value="{{$role['id']}}" disabled="true">{{ $role['role'] }}</option>		
															@else
																<option value="{{$role['id']}}">{{ $role['role'] }}</option>
															@endif
														@endforeach
													</select>													
												</div>
												<div class="row_hide">
												@if($member->role!='Member')
													@if($member->role=='PM')
														{{'Project Manager'}}
													@else
														{{$member->role}}
													@endif
												@else
												
													<ul><?php $count=0 ?>
														@foreach($tasks as $task)							
															@if($task['assignTo']==$member->memberId)

																@if($task['statusId']<=4)
																	<li>{{$task['task']}}&nbsp;
																	@if($task['statusId']==4)
																		<span class="label label-success">Current</span>
																	@endif
																	</li>
																	<?php $count++ ?>										
																@endif
															@endif
														@endforeach						
														@if($count==0)
															<li>Free</li>		
														@endif
													</ul>												
												@endif
												</div>
											</td>
											<td class="col-md-4 buttonGroup">
											@if(Session::get('role')==1)					
												@if($member->role!='PM')
												<a class="btn btn-primary btn-sm btnMemberRole" data-content="change/set Member role" data-trigger="hover" data-toggle="popover" data-placement="top">
													<span class="glyphicon glyphicon-edit"></span>
												</a>
												<a class="btn btn-danger btn-sm btnMemberDelete" data-content="delete Member" data-trigger="hover" data-toggle="popover" data-placement="top" >
													<span class="glyphicon glyphicon-trash"></span>												
												</a>												
												@endif
											@endif
											</td>					
										</tr>												
										@endforeach										
									</tbody>
								</table>
									
								<p><a class="btn btn-primary btn-sm" href="#addmember" data-toggle="modal" id="add_member">+ Add New Member</a></p>										
			 				</div> <!-- end of panel_body -->
						</div> 										
					</div> <!-- end of panel_wrapper -->
				</div> 
			</div> <!-- end of main_content -->									 	
		</div> <!-- end of main_content_wrapper -->
	</div> <!-- end of men_list -->	

<script>
	$(document).ready( function() {
		var tmp;
		

		$('#change_view').change(function() {
			var selectVal = $(this).val();
			if (selectVal != 'All'){
				$('.tr_hide').hide();		
			}
			else{
				$('.tr_hide').show();			
			}
		});	

		$('.buttonGroup a').popover('hide');
		$('.mem_role').hide();
		$('#btnSubmit').hide();

		$('.btnMemberRole').click(function(){
			$('.mem_role').hide();
			$('.tr_hide ul').show();
			$('.row_hide').show();
			var tr = $(this).closest('tr');
			tr.find('.row_hide').hide();
			tr.find('.mem_role').show();									
		})

		$('.cbo_role').change(function() {
			var tr = $(this).closest('tr');
			if(tr.find($('.cbo_role option:selected')).val()==1){
				$('#confirm_role_change').modal('show');
				tmp = tr;
			}
			else{
				$('#txtMemberId').val(tr.find('.memId').val());
				$('#txtRole').val(tr.find($('.cbo_role option:selected')).val());
				$('#btnSubmit').click();
			}
		});	

		$('.btnMemberDelete').click(function(){
			var tr = $(this).closest('tr');
			var memberId = tr.find('.memId').val();
			$('#confirm_member_delete #del_memberId').val(memberId);
			$('#confirm_member_delete').modal('show');

		});

		$('#confirm_role_change #btnYes').click(function(){
			$('#pm_role_change').val('true');
			$('#txtMemberId').val(tmp.find('.memId').val());
			$('#txtRole').val(tmp.find($('.cbo_role option:selected')).val());
			$('#btnSubmit').click();
		});

		$('#confirm_role_change #btnNo, #confirm_member_delete #btnNo').click(function(){
			window.location.reload();
		});												

		$('#confirm_member_delete #btnYes').click(function(){
			$('#confirm_member_delete #btnSubmit').click();
		})

		$('.btnMemberDetail').click(function(){
			var tr = $(this).closest('tr');				
			$memberId = tr.find('.memId').val();
			var url = '/member_detail?memberId=' + $memberId;
			$(this).attr('href', url);	
			$(this).click();
		});
	});
</script>

<div class="modal fade" id="addmember" role="dialog" aria-hidden="false" data-backdrop="static">
		@include('partials/add_member')
</div>

<div class="modal fade" id="confirm_role_change" role="dialog" aria-hidden="false" data-backdrop="static">
		@include('partials/confirm_role_change')
</div>

<div class="modal fade" id="confirm_member_delete" role="dialog" aria-hidden="false" data-backdrop="static">
		@include('partials/confirm_member_delete')
</div>

@stop