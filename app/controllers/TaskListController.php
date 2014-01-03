<?php 

class TaskListController extends BaseController{
	public function TaskList_add(){		
		$moduleId = Input::get('moduleId');
		$url = '/module_detail/?moduleId=' . $moduleId . '#moduleSection';	

		$validator = Validator::make(Input::all(), Config::get('validation.tasklist'));

		if ($validator->fails()){					
			return Redirect::to($url)->withInput()->withErrors($validator);	
		}
				
        $startDate 		  = date_create(Input::get('startDate'));
        $dueDate	 	  = date_create(Input::get('dueDate'));

		$tasklistId = TaskList::insertGetId(array(
			'tasklist' 			=> trim(Input::get('tasklistname')),
			'startDate'			=> $startDate->format('Y-m-d H:i:s'),
			'desc'				=> trim(Input::get('desc')),			
			'dueDate'			=> $dueDate->format('Y-m-d H:i:s'),
			'moduleId'			=> $moduleId
		));

		Module::where('moduleId',$moduleId)->update(array('status'=>'Progress'));

		$now = date('Y-m-d H:i:s');

		$notiId = Notification::insertGetId(array(
			'orgId'				=> Session::get('orgId'),
			'source'			=> 'tkl' . $tasklistId,
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
			'source'			=> 'tkl' . $tasklistId,
			'messageId'			=> 5,
			'dateToNoti'		=> $dueDate,
			'createdDate'		=> $now,
			'createdBy'			=> Session::get('memberId')
		));

		NotiDetail::insert(array(
			'notiId'			=> $notiId,
			'notiTo'			=> Session::get('memberId')
		));

		return Redirect::to($url);						
	}

	public function tasklist_update() {			
		$tasklistId = Input::get('tasklistId');		
		$key	  = Input::get('key');
		$value    = Input::get('value');

		$url = '/tasklist_detail/?tasklistId=' . $tasklistId;		

		if($key=='startDate'||$key=='dueDate'){
			$Date 		= date_create($value);
			$value		= $Date->format('Y-m-d H:i:s');	
		}					

		TaskList::where('tasklistId',$tasklistId)->update(array($key=>$value));

		$now = date('Y-m-d H:i:s');

		$notiId = Notification::insertGetId(array(
			'orgId'				=> Session::get('orgId'),
			'source'			=> 'tkl' . $tasklistId,
			'field'				=> $key,
			'messageId'			=> 2,
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

	public function tasklist_delete() {		
		$moduleId = Input::get('moduleId');		
		$tasklistId = Input::get('tasklistId');

		$url = '/module_detail/?moduleId=' . $moduleId . '#moduleSection';	

		TaskList::where('TaskList.tasklistId', $tasklistId)						
				->update(array('TaskList.status'=>'Delete'));

        $statusId = Status::where('Status.status','Delete')->pluck('statusId');
		TaskDetail::where('Task.tasklistId', $tasklistId)         		        	
	        	->join('Task','TaskDetail.taskId','=','Task.taskId')
	           	->update(array('TaskDetail.statusId'=>$statusId));  			

		$now = date('Y-m-d H:i:s');
		$notiId = Notification::insertGetId(array(
			'orgId'				=> Session::get('orgId'),
			'source'			=> 'tkl' . $tasklistId,
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

	public function tasklist_detail() {	
		if(Input::get('tasklistId')!=null)
			$tasklistId = Input::get('tasklistId');	
		else
			$tasklistId = Input::old('tasklistId');

		$para['tasklist'] = DB::select(
		"select TaskList.tasklistId, TaskList.tasklist, TaskList.desc, TaskList.startDate
	, TaskList.dueDate, TaskList.status, Project.authorizedBy, Progress.progress from TaskList
	left join 
  		( Module left join Project on Module.projectId = Project.projectId ) 
  	on TaskList.moduleId = Module.moduleId
    left join 
       	( select Upper.tasklistId, concat(cast(Upper.finish / Lower.total * 100 as signed), '%') progress 
       	from
		(select Tlist.tasklistId, (case when Status.status is null then 0 else Status.status end) finish from 
			(select distinct tasklistId from Task) Tlist 
			left join
				( select tasklistId, count(1) status from Task join TaskDetail 
					on Task.taskId = TaskDetail.taskId where statusId = 7 group by tasklistId) Status
			on Tlist.tasklistId = Status.tasklistId) Upper 
				inner join 
					( select Task.tasklistId, count(1) total from Task join 
						( TaskDetail join Status on TaskDetail.statusId = Status.statusId )
					 on Task.taskId = TaskDetail.taskId where Status.status != 'Delete' group by Task.tasklistId ) Lower 
				on Upper.tasklistId = Lower.tasklistId
		) Progress 
	on TaskList.tasklistId = Progress.tasklistId where TaskList.tasklistId = ?", array($tasklistId));

		$para['task'] = DB::select("select Task.taskId, Task.task, Task.startDate, Task.dueDate, Member.member, 
						Priority.priority, TaskDetail.desc, Status.status, TaskDetail.remark from Task left join 
			( TaskDetail left join Status on TaskDetail.statusId = Status.statusId ) on Task.taskId = TaskDetail.taskId 
			left join Member on Task.assignTo = Member.memberId left join Priority on Task.priorityId = Priority.priorityId 
			where Task.tasklistId = ? and Status.status <> 'Delete'", array($tasklistId));		

		$para['priority'] = Priority::select('Priority.priorityId', 'Priority.priority')->get();		

		$para['member'] = DB::select("Select Member.memberId, Member.member from Member left join 
			( users left join ( users_groups join groups on users_groups.group_id = groups.id ) 
			on users.id = users_groups.user_id) on Member.memberId = users.memberId 
			where Member.orgId = ? and groups.name = 'Member' order by users_groups.group_id",array(Session::get('orgId')));

		return View::make('partials/tasklist_detail')->with(array('para'=>$para));
	}	
}

 ?>