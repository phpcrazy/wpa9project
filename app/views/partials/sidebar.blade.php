@section('sidebar')
	<div id='sidebar_wrapper' class='col-md-2 '>

		<div class='list-group'>
			<a href='{{route('home')}}' class='list-group-item '>
				<i class='glyphicon glyphicon-home'></i><span>  {{Lang::get('caption.link.sidebar.dash')}}</span>
			</a>
			<a href='{{route('project_list')}}' class='list-group-item'><i class='glyphicon glyphicon-list'></i><span>  {{Lang::get('caption.link.sidebar.proj')}}</span></a>
			<a href='{{route('workarea')}}' class='list-group-item'><i class='glyphicon glyphicon-pushpin'></i><span>  {{Lang::get('caption.link.sidebar.work_area')}}</span></a>
			@if(Session::get('role')!=3)
			<a href='{{route('member_list')}}' class='list-group-item'><i class='glyphicon glyphicon-user'></i><span>  {{Lang::get('caption.link.sidebar.mem')}}</span></a>
			@endif
			<a href='progress.php' class='list-group-item'><i class='glyphicon glyphicon-stats'></i><span>  {{Lang::get('caption.link.sidebar.progress')}}</span></a>					
		</div>
						
	</div> <!-- end of sidebar_wrapper -->
@show
