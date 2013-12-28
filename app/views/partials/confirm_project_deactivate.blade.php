@section('confirm_project_deactivate')
	<div class="container c-form">						
		<div id="main_content_wrapper" class="row">				
			<div id="main_content" class="col-md-10">
				<div class="row">
					<div id="panel_wrapper" class="col-md-12">					
						<div class="panel panel-primary">
							<div class="panel-heading">
							    <h3 class="panel-title">Confirm Project Deactivation</h3>
							</div>
							<div class="panel-body">	
							{{ Form::open(array(
									'method'		=> 'post',
									'route'			=> 'project_deactivate',
									'autocomplete'	=> 'off',
									'class'			=> 'form-horizontal'
								))
							}}		
							{{ Form::hidden('projectId',0, array("class" => 'form-control', 'id' => 'txtprojectId'
							)) }}		
							{{ Form::submit('Submit', array('class' => 'btn btn-default', 'id'=>'btnSubmit')) }}
							{{ Form::close() }} 		
						 		<h3 class="text-danger">You are about to deactivate this project. You will need to reset every start date and due date fields related with the project.</h3></div>						   								   											
								<div id="btn">
									<a class="btn btn-danger" id="btnYes">Yes</a>
									<a class="btn btn-default" id="btnNo">No</a>
								</div>
							
							</div>			
						</div> <!--- end of panel_wrapper -->					
					</div> <!-- end of main_content -->		
				</div>	
			</div> <!-- end of main_content_wrapper -->
		</div>
	</div>
@show