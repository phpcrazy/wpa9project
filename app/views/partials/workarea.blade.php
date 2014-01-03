@extends('layouts.base')

@section('body')
	<div class="container" id="workarea">
		@include('partials.topNav')
		<div id="breadcrumb_wrapper" class="row text-right">
			<ol class="breadcrumb">
				<li><a href="{{route('home')}}">Home</a></li>			
				<li class="active">Work Area</li>
			</ol>			
		</div> <!-- end of breadcrumb_wrapper -->

		<div id="main_content_wrapper" class="row">
			@include('partials.sidebar')
		<div id="main_content" class="col-md-10">
			<div  id="panel_wrapper" class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Work Area</h3>
					</div>
					<div class="panel-body">
					@if(isset($para["task"]))
						<h4><span class="red_text"> {{$para["module"]["module"] . " of " . $para["project"]["project"]}}</span></h4>										
						@for($i=0;$i < count($para["tasklist"]);$i++)
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle list-group-item heading_link" data-toggle="collapse" data-parent="#accordion" href="#collapseProj1">
									<button class="btn btn-primary btn-xs">
									@if($num == $i)
										<span class="glyphicon glyphicon-minus"></span>
									@else
										<span class="glyphicon glyphicon-plus"></span>
									@endif
									</button>
									<span class="hide">{{$i}}</span>
									<div class="hide txtTaskListId">{{$para["tasklist"][$i]["tasklistId"]}}</div>
									{{$para["tasklist"][$i]["tasklist"]}}
								</a>
							</div>
							<div class="accordion-body collapse in task_detail">
								@if($num == $i)
									@include('partials/task_detail')
								@endif
							</div>
						</div>
						@endfor						
					@else
						@if(!isset($para["project"]))
							<h4> {{"There is no working project authorized by you. Please add project and come again"}}</h4>													
						@elseif(!isset($para["module"]))
							<h4> {{"No module in your only one project : " . $para["project"]["project"] . ". Please add module to the project and come again"}}</h4>
						@elseif(!isset($para["tasklist"]))
							<h4><span class="red_text"> {{$para["module"]["module"] . " of " . $para["project"]["project"]}}</span></h4>
							There is no any tasklist to show.
						@endif							
					@endif
					</div> <!--- end of panel-body -->
				</div> <!--- end of panel -->
			</div> <!--- end of panel_wrapper -->
		</div> <!--- end of main_content -->	
		<div id="task_area" class="col-md-3">
			@include('partials/add_task')
		</div>								
		</div> <!--- end of main_content_wrapper -->
	</div> <!--- end of workarea -->

	<script>
		$(function() {
			$( "#due_datepicker,#start_datepicker" ).datepicker({
				showButtonPanel: true
			});

			
		});

	</script>

<div class="modal fade" id="confirm_task_delete" role="dialog" aria-hidden="false" data-backdrop="static">
		@include('partials/confirm_task_delete')
</div>

@stop