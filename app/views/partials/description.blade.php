<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="glyphicon glyphicon-pushpin"></i> Description</h3>
	</div>
	<?php
	if($desc[0]=='empty'){
		$title = '';
		$desc1  = '';
	}
	else{
		$title = $desc[0]->title;
		$desc1  = $desc[0]->desc; 
	}
	?>
	<div class="panel-body">
		<h4 class="red_text">{{$title}}</h4>
		<p>{{$desc1}}</p>															
	</div>
</div>