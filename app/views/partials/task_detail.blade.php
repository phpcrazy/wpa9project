@if(isset($para['task']))

@if(!isset($num))
	<?php
		$num = 0;
		$tasks = $para['task'];
	?>
@else
	@if($num!=0)
	{{dd($para['tasklist'])}}
	@endif
	<?php $tasks = $para['task'][$num]; ?>	
@endif

{{ Form::open(array(
	'method'		=> 'post',
	'route'			=> 'task_update',
	'autocomplete'	=> 'off',
	'class'			=> 'form-horizontal'
	))
}}
{{ Form::hidden('source','', array('class' => 'form-control', 'id' => 'Source' )) }}	
{{ Form::hidden('num',$num, array('class' => 'form-control txtNum' )) }}
{{ Form::hidden('tasklistId',$para['tasklist'][$num]->tasklistId, array('class' => 'form-control' )) }}	
{{ Form::hidden('taskId','', array('class' => 'form-control','id'=>'txtTaskId' )) }}
{{ Form::hidden('taskname','', array('class' => 'form-control', 'id'=>'txtTask' )) }}	
{{ Form::hidden('desc','', array('class' => 'form-control','id'=>'txtDesc' )) }}
{{ Form::hidden('member','', array('class' => 'form-control','id'=>'txtAssignTo' )) }}
{{ Form::hidden('startDate','', array('class' => 'form-control', 'id'=>'txtStartDate' )) }}	
{{ Form::hidden('dueDate','', array('class' => 'form-control','id'=>'txtDueDate' )) }}
{{ Form::hidden('priority','', array('class' => 'form-control','id'=>'txtPriority' )) }}
{{ Form::submit('Submit', array('class' => 'btn btn-default hide', 'id'=>'btnSubmit')) }}
{{ Form::close() }}

<table class='table table-hover'>
	<thead>
		<tr>
			<th><i class='glyphicon glyphicon-list'></i> 
			Task Name</th>
			<th><i class='glyphicon glyphicon-calendar'></i> {{Lang::get('caption.label.detail.task_name')}}</th>			
			<th><i class='glyphicon glyphicon-sort-by-attributes'></i> {{Lang::get('caption.label.detail.priority')}}</th>
			<th><i class='glyphicon glyphicon-stats'></i> {{Lang::get('caption.label.detail.status')}}</th>
			<th><i class='glyphicon glyphicon-wrench'></i> {{Lang::get('caption.label.detail.action')}}</th>
		</tr>
	</thead>
	<tbody>					 
	@foreach($tasks as $task)								
		<tr>
			<td class='tId hide'>{{$task->taskId}}</td>
			<?php 
				$sdate1 = date_create($task->startDate);
				$sdate1 = $sdate1->format('d-F-Y');
				$ddate1 = date_create($task->dueDate);
				$ddate1 = $ddate1->format('d-F-Y');									
			?>
			<td><a class='link lkTask'>{{$task->task}}</a></td>
			<td>{{$ddate1}}</td>
			<!-- <td>Member1</td> -->
			<td>{{$task->priority}}</td>
			<td><span class='lblStatus label'>{{$task->status}}</span></td>					
			<td class='buttonGroup'>
			@if(isset($tasklists))
				@if(Session::get('memberId')==$tasklists[0]->authorizedBy&&$tasklists[0]->status!='Cancel'&&$tasklists[0]->status!='Delete'&&$tasklists[0]->status!='Pending')
					<a class='btn btn-primary btn-sm btnTaskEdit' data-content='edit task' data-trigger='hover' data-toggle='popover' data-placement='top'>
							<span class='glyphicon glyphicon-edit'></span>
						</a>
					<a class='btn btn-danger btn-sm btnTaskDelete' data-content='delete task' data-trigger='hover' data-toggle='popover' data-placement='top' >
						<span class='glyphicon glyphicon-trash'></span>					
					</a>
				@endif
			@else
				<a class='btn btn-primary btn-sm btnTaskEdit' data-content='edit task' data-trigger='hover' data-toggle='popover' data-placement='top'>
							<span class='glyphicon glyphicon-edit'></span>
				</a>
				<a class='btn btn-danger btn-sm btnTaskDelete' data-content='delete task' data-trigger='hover' data-toggle='popover' data-placement='top' >
					<span class='glyphicon glyphicon-trash'></span>					
				</a>
			@endif
			</td>											
		</tr>
		<tr class='trTaskDetail hide'>
			<td rowspan = 2><i class='glyphicon glyphicon-th-list'></i> <strong>{{Lang::get('caption.label.detail.desc')}} :</strong></td>
			<td rowspan = 2 colspan = 2><p class='lblDesc'>{{$task->desc}}</p></td>
			<td><i class='glyphicon glyphicon-user'></i><strong> {{Lang::get('caption.label.detail.a_to')}} :</strong></td>
			<td>{{$task->member}}</td>
		</tr>
		<tr class='trTaskDetail hide'>
			<td><i class='glyphicon glyphicon-calendar'></i><strong> {{Lang::get('caption.label.detail.s_date')}} :</strong></td>
			<td>{{$sdate1}}</td>
		</tr>
	@endforeach														
	</tbody>
</table>
<script>
	$(document).ready(function(){
		var tmp;
		$('.buttonGroup a').popover('hide');
		$('.lkTask').click(function(){
			$('.trTaskDetail').addClass('hide');
			var tr = $(this).closest('tr');		
			tr.next('.trTaskDetail').removeClass('hide').next('.trTaskDetail').removeClass('hide');
		});

		$('.btnTaskEdit').click(function(){
			tmp = $(this).closest('.task_detail');
			var tr = $(this).closest('tr');
			$('#add_task #txtTaskId').val(tr.find('.tId').text());
			$('#add_task #txtTask').val(tr.find('td:eq(1) a').text());
			$('#add_task #txtDesc').val(tr.next('.trTaskDetail').find('td:eq(1) p').text());
			var selector = '#add_task #cboAssignTo option:contains("' + tr.next('.trTaskDetail').find('td:eq(3)').text() + '")';
			var value = $(selector).val();
			$('#add_task #cboAssignTo').val(value);
			$('#add_task #StartDate').val(tr.next('.trTaskDetail').next('.trTaskDetail').find('td:eq(1)').text());
			$('#add_task #DueDate').val(tr.find('td:eq(2)').text());
			selector = '#add_task #cboPriority option:contains("' + tr.find("td:eq(3)").text() + '")';
			value = $(selector).val();
			$('#add_task #cboPriority').val(value);
			$('#add_task #btnSubmit').addClass('hide');
			$('#add_task #btnEdit').removeClass('hide');
			$('#add_task .heading span').text(' Task Edit Form');
		});

		$('.btnTaskDelete').click(function(){
	        var tr = $(this).closest('tr');
	        $taskId = tr.find('.tId').text();       
	        $('#confirm_task_delete #txtTaskListId').val($('#txtTaskListId').val());
	        $('#confirm_task_delete #txtTaskId').val($taskId);
	        $('#confirm_task_delete').modal('show');

	    });

	    $('#Source').each(function(){
	        var source = $(this).closest('body').find('div:first').attr('id');        
	        $(this).val(source);
	    });

	    $('.lblStatus').each(function(){
	        var status = $(this).text();
	        var tmp = 'label-';

            switch(status){
            	case 'Unchecked':
            		tmp+='start';break;
            	case 'Checked':
            		tmp+='default';break;
            	case 'Progress':
            		tmp+='success';break;
            	case 'Just Start':
            		tmp+='start';break;
            	case 'Submit':
            		tmp+='success';break;
            	case 'Finish':
            		tmp+='primary';break;
            	case 'Pending':
            		tmp+='warning';break;
            	default:
            		tmp+='danger';
            }
            
	        $(this).addClass(tmp);
	        
	    });

	    $('#add_task #btnEdit').click(function(){
			if(ValidateDate()){
				tmp.find('#txtTaskId').val($('#add_task #txtTaskId').val());
				tmp.find('#txtTask').val($('#add_task #txtTask').val());
				tmp.find('#txtDesc').val($('#add_task #txtDesc').val());
				tmp.find('#txtStartDate').val($('#add_task #StartDate').val());
				tmp.find('#txtDueDate').val($('#add_task #DueDate').val());
				tmp.find('#txtAssignTo').val($('#add_task #cboAssignTo option:selected').val());
				tmp.find('#txtPriority').val($('#add_task #cboPriority option:selected').val());
				tmp.find('#btnSubmit').click();
			}
		});

		$('#workarea .heading_link').click(function(){
			$('.accordion-group button span').attr('class', 'glyphicon glyphicon-plus');
			var tmp = $(this).closest('.accordion-group');
			tmp.find('button span').attr('class', 'glyphicon glyphicon-minus');				
			var num = $(this).children('span.hide').text();		
			$('#txtTaskListId').val(tmp.find('div.hide').text());
			$('.txtNum').val(num);
			var url = '/workarea?num=' + num + '&source=task_detail';
			$('#workarea .task_detail').each(function(){
				$(this).hide();
			})
			tmp.find('.task_detail').load(url);
			tmp.find('.task_detail').show();
			
		});		

	});
</script>

@endif