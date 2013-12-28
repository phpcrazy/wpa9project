<?php 

class TaskController extends BaseController{
	public function task_add(){
		$tasklistId = Input::get('tasklistId');
		$url = '/tasklist_detail/?tasklistId=' . $tasklistId . '#tasklistSection';

		$validator = Validator::make(Input::all(), Config::get('validation.task'));

		if ($validator->fails()){			
			return Redirect::to($url)->withInput()->withErrors($validator);	
		}

		$startDate 		= date_create(Input::get('startDate'));
        $dueDate	   	= date_create(Input::get('dueDate'));

        if(Input::get('member')	=='Please Choose')$member = null;
        else $member = Input::get('member');

		$taskId = Task::insertGetId(array(
			'orgId'			=> Session::get('orgId'),
			'task' 			=> trim(Input::get('taskname')),
			'assignTo'		=> $member,
			'startDate'	    => $startDate->format('Y-m-d H:i:s'),
			'priorityId'	=> Input::get('priority'),
			'dueDate'		=> $dueDate->format('Y-m-d H:i:s'),
			'tasklistId'	=> $tasklistId
		));

		TaskDetail::insert(array(
			'taskId'		=> $taskId,
			'desc'			=> trim(Input::get('desc'))
		));

		TaskList::where('tasklistId',$tasklistId)->update(array('status'=>'Progress'));

		$now = date('Y-m-d H:i:s');

		$notiId = Notification::insertGetId(array(
			'orgId'				=> Session::get('orgId'),
			'source'			=> 'tsk' . $taskId,
			'messageId'			=> 1,
			'dateToNoti'		=> $now,
			'createdDate'		=> $now,
			'createdBy'			=> Session::get('memberId')
		));

		NotiDetail::insert(array(
			'notiId'			=> $notiId,
			'notiTo'			=> Session::get('memberId')
		));

		$dueDate = date_sub($dueDate, date_interval_create_from_date_string('2 days'));
		$notiId = Notification::insertGetId(array(
			'orgId'				=> Session::get('orgId'),
			'source'			=> 'tsk' . $taskId,
			'messageId'			=> 5,
			'dateToNoti'		=> $dueDate,
			'createdDate'		=> $now,
			'createdBy'			=> Session::get('memberId')
		));

		NotiDetail::insert(array(
			'notiId'			=> $notiId,
			'notiTo'			=> Session::get('memberId')
		));
		if($member!=null){
			NotiDetail::insert(array(
				'notiId'			=> $notiId,
				'notiTo'			=> $member
			));
		}

		if($member!=null){
			$notiId = Notification::insertGetId(array(
				'orgId'				=> Session::get('orgId'),
				'source'			=> 'tsk' . $taskId,
				'field'				=> $member,
				'messageId'			=> 4,
				'dateToNoti'		=> $now,
				'createdDate'		=> $now,
				'createdBy'			=> Session::get('memberId')
			));

			NotiDetail::insert(array(
				'notiId'			=> $notiId,
				'notiTo'			=> Session::get('memberId')
			));
			NotiDetail::insert(array(
				'notiId'			=> $notiId,
				'notiTo'			=> $member
			));
		}

		return Redirect::to($url);					
	}	

	public function task_update() {				
		$tasklistId = Input::get('tasklistId');		
		$validator = Validator::make(Input::all(), Config::get('validation.task'));	
		$url = '/tasklist_detail/?tasklistId=' . $tasklistId;	

		if ($validator->fails()){			
			return Redirect::to($url)->withInput()->withErrors($validator);	
		}

		$startDate 		= date_create(Input::get('startDate'));
        $dueDate	   	= date_create(Input::get('dueDate'));		

		if(Input::get('member')	=='Please Choose')$member = null;
        else $member = Input::get('member');

		$taskId = Input::get('taskId');

		Task::where('taskId', $taskId)
			->update(array(			
			'task' 			=> trim(Input::get('taskname')),
			'assignTo'		=> $member,
			'startDate'	    => $startDate->format('Y-m-d H:i:s'),
			'priorityId'	=> Input::get('priority'),
			'dueDate'		=> $dueDate->format('Y-m-d H:i:s')			
		));

		TaskDetail::where('taskId', $taskId)
			->update(array('desc'=> trim(Input::get('desc'))
		));

		$now = date('Y-m-d H:i:s');

		$notiId = Notification::insertGetId(array(
			'orgId'				=> Session::get('orgId'),
			'source'			=> 'tsk' . $taskId,
			'messageId'			=> 8,
			'dateToNoti'		=> $now,
			'createdDate'		=> $now,
			'createdBy'			=> Session::get('memberId')
		));

		NotiDetail::insert(array(
			'notiId'			=> $notiId,
			'notiTo'			=> Session::get('memberId')
		));

		return Redirect::to($url);
	}

	public function task_delete() {		
		$tasklistId = Input::get('tasklistId');		
		$taskId = Input::get('taskId');

		$url = '/tasklist_detail/?tasklistId=' . $tasklistId . '#tasklistSection';			
		
		$statusId = Status::where('Status.status','Delete')->pluck('statusId');

		TaskDetail::where('TaskDetail.taskId', $taskId)					
					->update(array('TaskDetail.statusId'=>$statusId));  			

		$now = date('Y-m-d H:i:s');
		$notiId = Notification::insertGetId(array(
			'orgId'				=> Session::get('orgId'),
			'source'			=> 'tsk' . $taskId,
			'messageId'			=> 3,
			'dateToNoti'		=> $now,
			'createdDate'		=> $now,
			'createdBy'			=> Session::get('memberId')
		));

		NotiDetail::insert(array(
			'notiId'			=> $notiId,
			'notiTo'			=> Session::get('memberId')
		));			

		return Redirect::to($url);
	}
}
?>
