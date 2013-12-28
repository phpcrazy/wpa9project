<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="glyphicon glyphicon-pushpin"></i> Description</h3>
	</div>{{dd(count($desc));}}
	@if(count($desc)==1)
		$title = '';dd('hey');
		$desc1  = '';
	@else 
		$title = $desc[0]->title;
		$desc1  = $desc[0]->desc;
	@endif
	<div class="panel-body">
		<h4 class="red_text">{{$title}}</h4>
		<p>{{$desc1}}</p>															
	</div>
</div>