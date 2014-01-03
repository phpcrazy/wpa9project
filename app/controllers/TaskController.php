<?php 

class TaskController extends BaseController{
	public function task_add(){
		$num = Input::get('num');
		$tasklistId = Input::get('tasklistId');
		
		if(Input::get('source')=='workarea')
			$url = '/workarea/?num=' . $num;

		else if(Input::get('source')=='tasklist_detail')
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
		$num = Input::get('num');			
		$tasklistId = Input::get('tasklistId');		
		$validator = Validator::make(Input::all(), Config::get('validation.task'));	

		if(Input::get('source')=='workarea')
			$url = '/workarea/?num=' . $num;

		else if(Input::get('source')=='tasklist_detail')
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

		return Redirect::to($url);
	}

	public function task_delete() {	
		$num = Input::get('num');	
		$tasklistId = Input::get('tasklistId');		
		$taskId = Input::get('taskId');

		if(Input::get('source')=='workarea')
			$url = '/workarea/?num=' . $num;

		else if(Input::get('source')=='tasklist_detail')
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

	public function workarea(){
		if(Input::get('num')==null)
			$num = 0;
		else
			$num = Input::get('num');

		if(Input::get('projectId')==null){
			if(count(Project::where('authorizedBy',Session::get('memberId'))
				->whereNotIn('status',array('Finished','Cancel','Pending'))
				->select('projectId')->orderBy('projectId')->get())==0)
				return View::make('partials/workarea');		
			
			$para["project"] = Project::where('authorizedBy',Session::get('memberId'))
				->whereNotIn('status',array('Finished','Cancel','Pending'))
				->select('projectId','project')->orderBy('projectId')->get()[0];
		}
				
		else
			$para["project"] = array('projectId'=>Input::get('projectId')
				,'project'=>Project::where('projectId',Input::get('projectId'))->pluck('project'));						

		if(count(Module::where('projectId',$para["project"]["projectId"])
			->where('active',1)->select('moduleId')->get())==0)
			return View::make('partials/workarea')->with(array('para'=>$para));

		$para["module"] = Module::where('active',1)->where('projectId',$para["project"]["projectId"])->select('moduleId','module')->get()[0];		

		if(count(TaskList::where('moduleId',$para["module"]["moduleId"])->where('status','!=','Delete')
			->select('tasklistId')->get())==0)
			return View::make('partials/workarea')->with(array('para'=>$para));

		$para["tasklist"] = TaskList::where('moduleId',$para["module"]["moduleId"])->where('status','!=','Delete')
						->select('tasklistId','tasklist')->orderBy('tasklistId')->get();		

		$i=0;
		foreach($para["tasklist"] as $tasklist){		
			$para["task"][$i] = DB::select("select Task.taskId, Task.task, Task.startDate, Task.dueDate, Member.member, 
							Priority.priority, TaskDetail.desc, Status.status, TaskDetail.remark from Task left join 
				( TaskDetail left join Status on TaskDetail.statusId = Status.statusId ) on Task.taskId = TaskDetail.taskId 
				left join Member on Task.assignTo = Member.memberId left join Priority on Task.priorityId = Priority.priorityId 
				where Task.tasklistId = ? and Status.status <> 'Delete'", array($tasklist->tasklistId));

			$i++;
		}

		$para["member"] = DB::select("Select Member.memberId, Member.member from Member left join 
			( users left join ( users_groups join groups on users_groups.group_id = groups.id ) 
			on users.id = users_groups.user_id) on Member.memberId = users.memberId 
			where Member.orgId = ? and groups.name = 'Member' order by users_groups.group_id",array(Session::get('orgId')));

		$para["priority"] = Priority::select('Priority.priorityId', 'Priority.priority')->get();

		if(Input::get('source')=='task_detail')
			return View::make('partials/task_detail')->with(array('para'=>$para, 'num'=>$num));	
		
		return View::make('partials/workarea')->with(array('para'=>$para, 'num'=>$num));
	}
}
?>
