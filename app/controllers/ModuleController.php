<?php 

class ModuleController extends BaseController{
	public function module_add(){					
		$projectId = Input::get('projectId');
		$url = '/project_detail/?projectId=' . $projectId . '#projectSection';	
		
		$validator = Validator::make(Input::all(), Config::get('validation.module'));		

		if ($validator->fails()){					

			return Redirect::to($url)->withInput()->withErrors($validator);	
		}		

        $startDate     = date_create(Input::get('startDate'));
        $dueDate	   = date_create(Input::get('dueDate'));

		$moduleId = Module::insertGetId(array(
			'module' 			=> trim(Input::get('modulename')),
			'startDate'			=> $startDate->format('Y-m-d H:i:s'),
			'desc'				=> trim(Input::get('desc')),			
			'dueDate'			=> $dueDate->format('Y-m-d H:i:s'),
			'projectId'			=> $projectId
		));

		Project::where('projectId',$projectId)->update(array('status'=>'Progress'));

		$now = date('Y-m-d H:i:s');

		$notiId = Notification::insertGetId(array(
			'orgId'				=> Session::get('orgId'),
			'source'			=> 'mod' . $moduleId,
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
			'source'			=> 'mod' . $moduleId,
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

	public function module_detail() {	
		if(Input::get('moduleId')!=null)
			$moduleId = Input::get('moduleId');	
		else
			$moduleId = Input::old('moduleId');

		Session::put('moduleId',$moduleId);

		$modules = DB::select(
		"select Module.moduleId, Module.module, Module.desc, Module.startDate, Module.dueDate
			, Module.status, Project.authorizedBy, concat(sum(Progress.progress)/count(Module.moduleId), '%') progress from Module
	left join Project on Module.projectId = Project.projectId 
	left join TaskList on Module.moduleId = TaskList.moduleId 
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
					( select tasklistId, count(1) total from Task group by tasklistId) Lower 
				on Upper.tasklistId = Lower.tasklistId
		) Progress
	on TaskList.tasklistId = Progress.tasklistId where Module.moduleId = ? group by Module.moduleId", array($moduleId));
		
		$tasklists = DB::select(
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
					( select tasklistId, count(1) total from Task group by tasklistId) Lower 
				on Upper.tasklistId = Lower.tasklistId
		) Progress 
	on TaskList.tasklistId = Progress.tasklistId where Module.moduleId = ? and TaskList.status <> 'Delete'", array($moduleId));

		return View::make('partials/module_detail')->with(array('modules'=> $modules, 'tasklists'=>$tasklists));
	}

	public function module_update() {
		$projectId = Input::get('projectId');		
		$moduleId = Input::get('moduleId');		
		$key	  = Input::get('key');
		$value    = Input::get('value');

		if($key=='active'){
			$url = '/project_detail/?projectId=' . $projectId . '#projectSection';	
			Module::where('projectId',$projectId)->update(array($key=>0));
		}
		else{
			$url = '/module_detail/?moduleId=' . $moduleId;	
		}				

		if($key=='startDate'||$key=='dueDate'){
			$Date 		= date_create($value);
			$value		= $Date->format('Y-m-d H:i:s');	
		}	

		Module::where('moduleId',$moduleId)->update(array($key=>$value));
		if($key!='active'){
			$now = date('Y-m-d H:i:s');

			$notiId = Notification::insertGetId(array(
				'orgId'				=> Session::get('orgId'),
				'source'			=> 'mod' . $moduleId,
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
		}
		return Redirect::to($url);
	}

	public function module_delete() {		
		$projectId = Input::get('projectId');		
		$moduleId = Input::get('moduleId');
		$url = '/project_detail/?projectId=' . $projectId . '#projectSection';	

		Module::where('Module.moduleId', $moduleId)					
			->update(array('Module.status'=>'Delete'));		

		TaskList::where('TaskList.moduleId', $moduleId)						
				->update(array('TaskList.status'=>'Delete'));

		$tasklistIds = TaskList::where('TaskList.moduleId', $moduleId)
          		->select('tasklistId')->get();

        $statusId = Status::where('Status.status','Delete')->pluck('statusId');
		foreach($tasklistIds as $tasklistId){
			TaskDetail::where('Task.tasklistId', $tasklistId->tasklistId)         		        	
		        	->join('Task','TaskDetail.taskId','=','Task.taskId')
		           	->update(array('TaskDetail.statusId'=>$statusId));  				
		}

		$now = date('Y-m-d H:i:s');
		$notiId = Notification::insertGetId(array(
			'orgId'				=> Session::get('orgId'),
			'source'			=> 'mod' . $moduleId,
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