@section('sidebar')
	<div id="sidebar_wrapper" class="col-md-2 ">

		<div class="list-group">
			<a href="{{route('home')}}" class="list-group-item ">
				<i class="glyphicon glyphicon-home"></i><span>  Dashboard</span>
			</a>
			<a href="{{route('project_list')}}" class="list-group-item"><i class="glyphicon glyphicon-list"></i><span>  Projects</span></a>
			<a href="workarea.php" class="list-group-item"><i class="glyphicon glyphicon-pushpin"></i><span>  Work Area</span></a>
			@if(Session::get('role')!=3)
			<a href="{{route('member_list')}}" class="list-group-item"><i class="glyphicon glyphicon-user"></i><span>  Members</span></a>
			@endif
			<a href="progress.php" class="list-group-item"><i class="glyphicon glyphicon-stats"></i><span>  Progress</span></a>					
		</div>
						
	</div> <!-- end of sidebar_wrapper -->
@show
