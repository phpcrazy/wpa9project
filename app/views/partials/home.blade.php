@extends('layouts.base')

@section('body')

@if($errors->has('projectname')||$errors->has('startDate')||$errors->has('dueDate'))
	<script>
		$(document).ready( function() {
	  		$('#btnAddProject').click();
		});						
	</script>
@elseif($errors->has('clientname')||$errors->has('username')||$errors->has('password'))
	<script>
		$(document).ready( function() {
	  		$('#btnAddClient').click();
		});						
	</script>
@endif

	<div id='dashboard' class='container'>
		@include('partials.topNav')
		<div id='breadcrumb_wrapper' class='row text-right'>
			<ol class='breadcrumb'>
				<li><a href='dashboard.php'>Home</a></li>
				<li class='active'>Dashboard</li>

			</ol>			
		</div> <!-- end of breadcrumb_wrapper -->
		<div id='add_area' class='row'>
			<div class='text-right'>
				<a href='#addProject' data-toggle='modal' class='btn btn-primary' id='btnAddProject'><i class='glyphicon glyphicon-plus'></i> {{Lang::get('caption.link.button.add_proj')}}</a>
				<a href='#addClient' data-toggle='modal' class='btn btn-primary' id='btnAddClient'> <i class='glyphicon glyphicon-plus'></i> {{Lang::get('caption.link.button.add_client')}}</a>
			</div>
		</div> <!--- end of add_area -->

		<div id='main_content_wrapper' class='row'>
				@include('partials.sidebar')
			<div id='main_content' class='col-md-10'>
				<div class='row'>
					<div id='noti_area' class='col-md-6'>
						<div class='panel panel-primary'>
							<div class='panel-heading'>
						   		<span class='hide'>{{Lang::get('caption.title.home_main')}}</span>
								<h3 class='panel-title'><i class='glyphicon glyphicon-bell'></i> {{Lang::get('caption.title.home.notification')}}</h3>
							</div>

							<div class='panel-body'>							
								<div class='accordion' id='accordion'>
									<!--- Today noti -->
									<div class='accordion-group'>
										<div class='accordion-heading'>
											<a class='accordion-toggle list-group-item heading_link' data-toggle='collapse' data-parent='#accordion' href='#noti_detail'>
												<button class='btn btn-primary btn-xs'>
													<span class='glyphicon glyphicon-minus'></span>
												</button>
												<?php $date0 = date('d-M-Y') ?>
												<span class='hidden'>{{$date0}}</span>
												<strong>Today</strong>
												@if(isset($count))
												<span class='badge pull-right'>{{$count[0]}}</span>
												@endif
											</a>
										</div>
										<div class='accordion-body collapse in noti_detail'>
										@include('partials/noti_detail')
										</div>
									</div>
									<!--- End Today noti -->
									@for($i=1;$i < 30;$i++)
									<?php
										 $date = date_sub(date_create(date('Y-m-d H:i:s')), date_interval_create_from_date_string($i . ' days'));
										 $date1 = $date->format('d/m/Y');
										 $date2 = $date->format('d-M-Y');
									?>
									<!--- other noti -->
									<div class='accordion-group'>
										<div class='accordion-heading'>
											<a class='accordion-toggle list-group-item heading_link' data-toggle='collapse' data-parent='#accordion' href='#collapse_two'>
												<button class='btn btn-primary btn-xs'>
													<span class='glyphicon glyphicon-plus'></span>
												</button>
												<span class='hidden'>{{$date2}}</span>
												<strong>{{$date1}}</strong>
												@if(isset($count))
													<span class='badge pull-right'>{{$count[$i]}}</span>
												@endif
											</a>
										</div>
										<div class='accordion-body collapse in noti_detail'>

										</div>										
									</div>
									@endfor
									<!--- End other noti -->
								</div>
							</div>
						</div>
					</div> <!-- end of noti_area -->

					<div id='description_area' class='col-md-6'>
						@include('partials/description')						
					</div> <!-- end of description_area -->
				</div>				
			</div> <!-- end of main_content -->			
		</div> <!-- end of main_content_wrapper -->
	</div>

<div class='modal fade' id='addProject' role='dialog' aria-hidden='false' data-backdrop='static'>
	@include('partials/add_project')
</div>

<div class='modal fade' id='addClient' role='dialog' aria-hidden='false' data-backdrop='static'>
	@include('partials/add_client')
</div>

<script>
	$(document).ready(function(){
		notiTypeStyle($('#noti_area .noti_detail .noti_format span.label'));			
	})	

</script>
@stop