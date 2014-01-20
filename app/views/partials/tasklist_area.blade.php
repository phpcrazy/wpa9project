
	<div class='panel panel-primary'>
		<div class='panel-heading'>
			<span class='hide'>{{Lang::get('caption.title.workarea')}}</span>
			<h3 class='panel-title'>{{Lang::get('caption.title.workarea')}}</h3>
		</div>
		<div class='panel-body'>
		<div class='row'>
			<div class='col-md-3 col-md-offset-1' id='projectChoose'>
	  		<select class='form-control text-center' id='cboProject'>						  			
				@foreach($para['projects'] as $project)
					@if($para['project']->project==$project->project)						
						<option selected='true' value='{{$project->projectId}}' disabled='true'>{{ $project->project }}</option>		
					@else
						<option value='{{$project->projectId}}'>{{ $project->project }}</option>
					@endif
				@endforeach
			</select>
		</div>
		</div>							
		@if(isset($para['task']))
			<h4><span class='red_text'> {{$para['module']->module . ' of ' . $para['project']->project}}</span></h4>										
			@for($i=0;$i < count($para['tasklist']);$i++)
			<div class='accordion-group'>
				<div class='accordion-heading'>
					<a class='accordion-toggle list-group-item heading_link' data-toggle='collapse' data-parent='#accordion' href='#collapseProj1'>
						<button class='btn btn-primary btn-xs'>
						@if($num == $i)
							<span class='glyphicon glyphicon-minus'></span>
						@else
							<span class='glyphicon glyphicon-plus'></span>
						@endif
						</button>
						<span class='hide'>{{$i}}</span>
						<div class='hide txtTaskListId'>{{$para['tasklist'][$i]->tasklistId}}</div>
						{{$para['tasklist'][$i]->tasklist}}
					</a>
				</div>
				<div class='accordion-body collapse in task_detail'>
					@if($num == $i)
						@include('partials/task_detail')
					@endif
				</div>
			</div>
			@endfor		
			<div id='addTaskList'><a class='btn btn-primary btn-sm' href='#addTasklist' data-toggle='modal' id='btnAddTaskList'>+ {{Lang::get('caption.link.button.add_tasklist')}}</a></div>				
		@else
			@if(!isset($para['project']))
				<h4> {{'There is no working project authorized by you. Please add project and come again'}}</h4>													
			@elseif(!isset($para['module']))
				<h4> {{'No module in your only one project : ' . $para['project']->project . '. Please add module to the project and come again'}}</h4>
			@else
				<h4><span class='red_text'> {{$para['module']->module . ' of ' . $para['project']->project}}</span></h4>
				@if(!isset($para['tasklist']))										
					There is no any tasklist to show.
				@endif
				<div id='addTaskList'><a class='btn btn-primary btn-sm' href='#addTasklist' data-toggle='modal' id='btnAddTaskList'>+ Add New Tasklist</a></div>				
			@endif							
		@endif
		</div> <!--- end of panel-body -->
	</div> <!--- end of panel -->

<div class='modal fade' id='addTasklist' role='dialog' aria-hidden='false' data-backdrop='static'>
		@include('partials/add_tasklist')
</div>

<script>
		$(document).ready(function(){
			$('#cboProject').change(function() {
				var projectId = $('#cboProject option:selected').val();
				var url = '?projectId=' + projectId;
				$('#tasklist_area').load(url);
			});
		});

</script>