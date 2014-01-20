@extends('layouts.base')

@section('body')

	@if($errors->has())
		<script>
			$(document).ready( function() {
		  		$('#btnAddTaskList').click();
			});						
		</script>
	@endif
	<div class='container' id='workarea'>
		@include('partials.topNav')
		<div id='breadcrumb_wrapper' class='row text-right'>
			<ol class='breadcrumb'>
				<li><a href='{{route('home')}}'>Home</a></li>			
				<li class='active'>Work Area</li>
			</ol>			
		</div> <!-- end of breadcrumb_wrapper -->

		<div id='main_content_wrapper' class='row'>
			@include('partials.sidebar')
			<div id='main_content' class='col-md-10'>
				<div class='row'>
					<div id='tasklist_area' class='col-md-8'>
						@include('partials/tasklist_area')
					</div> <!--- end of tasklist_area -->
					<div id='task_area' class='col-md-4'>
						@include('partials/add_task')
					</div>	
				</div>
			</div> <!--- end of main_content -->										
		</div> <!--- end of main_content_wrapper -->
	</div> <!--- end of workarea -->

	

<div class='modal fade' id='confirm_task_delete' role='dialog' aria-hidden='false' data-backdrop='static'>
	@include('partials/confirm_task_delete')
</div>

@stop