	<div class="accordion-inner">	
	<?php
	if($notis[0]!='empty'){
		$i=0;
	?>
		@foreach($notis as $noti)												
		<div class="noti_format">
			<p>
				<span class="hide">{{$noti->notiTypeId}}</span>
				<span class="label">{{$noti->Type}}</span>
				{{$noti->Details}}
			</p>
			<span class='hide'>{{$i}}</span>
		</div>
		<?php $i++ ?>
		@endforeach
	<?php }	?>
	</div>

<script>
	$(document).ready(function(){


		$('#noti_area .hidden').hide();
		$('#noti_area .noti-heading').click(function(){
			$('.accordion-group button span').attr('class', 'glyphicon glyphicon-plus');
			var tmp = $(this).closest('.accordion-group');
			tmp.find('button span').attr('class', 'glyphicon glyphicon-minus');			
			var date = $(this).closest('.accordion-group').find('span.hidden').text();		
			if(date == 'Today')date = Datejs.toString('yyyy-MM-dd HH:mm');
			var url = '/home?date=' + date;
			$('#noti_area .noti_detail').each(function(){
				$(this).hide();
			})
			tmp.find('.noti_detail').load(url,function(){
				notiTypeStyle($('#noti_area .noti_detail .noti_format span'));
			});
			tmp.find('.noti_detail').show();
			
		});

		$('.noti_format').click(function(){
			var num = $(this).children('span.hide').text();
			var date = $(this).closest('.accordion-group').find('span.hidden').text();	
			var url = '/home?date=' + date + '&num=' + num;
			$('#description_area').load(url);
		});


	})

</script>