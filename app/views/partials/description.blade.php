<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="glyphicon glyphicon-pushpin"></i> {{Lang::get('caption.title.home.description')}}</h3>
	</div>
	<div class="panel-body">
	<?php if(isset($desc)){ ?>
		<h4 class="red_text">{{$desc[0]->title}}</h4>
		<p>{{$desc[0]->desc}}</p>															
	<?php } ?>
	</div>
</div>