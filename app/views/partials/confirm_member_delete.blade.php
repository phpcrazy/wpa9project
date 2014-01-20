@section('confirm_member_delete')
	<div class="container c-form">						
		<div id="main_content_wrapper" class="row">				
			<div id="main_content" class="col-md-10">
				<div class="row">
					<div id="panel_wrapper" class="col-md-12">					
						<div class="panel panel-primary">
							<div class="panel-heading">
							    <h3 class="panel-title">{{Lang::get('caption.title.confirm_member_delete')}}</h3>
							</div>
							<div class="panel-body">
								{{ Form::open(array(
									'method'		=> 'post',
									'route'			=> 'member_delete',
									'autocomplete'	=> 'off',
									'class'			=> 'form-horizontal'
									))
								}}
								{{ Form::hidden('memberId',0, array("class" => 'form-control','id'=>'up_memberId'
								)) }}		
								{{ Form::hidden('role',0, array("class" => 'form-control','id'=>'up_role'
								)) }}				 		
						 		<h3 class="text-danger">{{Lang::get('caption.label.confirm_member_delete')}}</h3></div>						   								   											
								{{ Form::hidden('memberId',0, array("class" => 'form-control', 'id'=>'del_memberId'
								)) }}
								<div id="btn">
									<input type="submit" id="btnSubmit" class="hide">
									<a class="btn btn-danger" id="btnYes">Lang::get('caption.link.button.yes')</a>
									<a class="btn btn-default" id="btnNo">Lang::get('caption.link.button.no')</a>
								</div>
								{{ Form::close() }}
							</div>			
						</div> <!--- end of panel_wrapper -->					
					</div> <!-- end of main_content -->		
				</div>	
			</div> <!-- end of main_content_wrapper -->
		</div>
	</div>
@show