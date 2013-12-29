		<h4 class="red_text">Events on {{$projects[0]->project}}</h4>
		<table class="table table-hover">
		 <thead>
			<tr>
				<th><i class="glyphicon glyphicon-calendar"></i> Date</th>
				<th><i class="glyphicon glyphicon-user"></i> By</th>
				<th><i class="glyphicon glyphicon-list"></i> Type</th>
				<th><i class="glyphicon glyphicon-tags"></i> Details</th>
			</tr>
		</thead>
		<tbody>
		@foreach($events as $event)										
			<tr>
				<td>{{$event->Date}}</td>
				<td>{{$event->By}}</td>
				<td>{{$event->Type}}</td>
				<td>{{$event->Details}}</td>
			</tr>							
		@endforeach															
		</tbody>
	</table>		
	{{ $links->links();}}																
	<div class='perPage'>
	{{ Form::text('perPage', $limit, array("class"=>'form-control','id'=>'txtPerPage'
	)) }}
	</div>
	<div class='perPage'>
		<p>Per Page</p>
	</div>									

<script>
	$(document).ready(function(){
		$('#eventSection #txtPerPage').keypress(function(e){
			var code = e.keyCode || e.which;
			if(code == 13){
				var pageId = 1;
				var limit = $('#eventSection #txtPerPage').val();
				var url = "?projectId=" + $('#txtProjectId').val() + "&page=" + pageId + "&limit=" + limit;				
				$("#eventSection").load(url);
			}
		});

		$('#eventSection .pagination a').click(function(event){		
			var liCount = $('#eventSection .pagination li').length-2;
			var pageId = $(this).text();
			var limit = $('#eventSection #txtPerPage').val();
			if(pageId =='«')pageId = 1;
			else if (pageId == '»')pageId = $('#eventSection .pagination li:eq(' + liCount + ') a').text();
			event.preventDefault();	
			var url = "?projectId=" + $('#txtProjectId').val() + "&page=" + pageId + "&limit=" + limit;			
			$("#eventSection").load(url);
		});
	});
</script>