<?php 

class ProjectController extends BaseController{
	public function project_add(){			
		$validator = Validator::make(Input::all(), Config::get('validation.project'));

		if ($validator->fails()){					

			return Redirect::route('home')->withInput()->withErrors($validator);	
		}
		
        $startDate 		= date_create(Input::get('startDate'));
        $dueDate	   	= date_create(Input::get('dueDate'));

        if(Input::get('client')=='Please Choose Client Name')$client = null;
        else $client = Input::get('client');

		$projectId = Project::insertGetId(array(
			'orgId'				=> Session::get('orgId'),
			'project' 			=> trim(Input::get('projectname')),
			'desc'				=> trim(Input::get('desc')),
			'startDate'			=> $startDate->format('Y-m-d H:i:s'),			
			'dueDate'			=> $dueDate->format('Y-m-d H:i:s'),
			'authorizedBy'		=> Session::get('memberId'),
			'clientId'			=> $client
		));

		$now = date('Y-m-d H:i:s');

		$notiId = Notification::insertGetId(array(
			'orgId'				=> Session::get('orgId'),
			'source'			=> 'prj' . $projectId,
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
			'source'			=> 'prj' . $projectId,
			'messageId'			=> 5,
			'dateToNoti'		=> $dueDate,
			'createdDate'		=> $now,
			'createdBy'			=> Session::get('memberId')
		));

		NotiDetail::insert(array(
			'notiId'			=> $notiId,
			'notiTo'			=> Session::get('memberId')
		));

		return Redirect::route('home');
			
	}

	public function project_list() {			
		$para['project'] = DB::select(
"select Mdule.projectId, Mdule.project, Mdule.desc, Mdule.startDate,Mdule.dueDate
    , Mdule.status, Mdule.member, Mdule.client, concat(sum(progress)/count(1), '%') progress from(
	select Project.projectId, Project.project, Project.desc, Project.startDate,Project.dueDate
			, Project.status, Member.member, Client.client, concat(sum(Progress.progress)/count(Module.moduleId), '%') progress  from Project
	left join 
			( Module left join TaskList on Module.moduleId = TaskList.moduleId ) 	
		on Project.projectId = Module.projectId
	left join Client on Project.clientId = Client.clientId
	left join Member on Project.authorizedBy = Member.memberId
	left join 
	   	( select Upper.tasklistId, concat(cast(Upper.finish / Lower.total * 100 as signed), '%') progress 
	   	from
		(select Tlist.tasklistId, (case when Status.status is null then 0 else Status.status end) finish from 
			(select distinct tasklistId from Task) Tlist 
			left join
				( select tasklistId, count(1) status from Task join TaskDetail 
					on Task.taskId = TaskDetail.taskId where statusId = 9 group by tasklistId) Status
			on Tlist.tasklistId = Status.tasklistId) Upper 
				inner join 
					( select Task.tasklistId, count(1) total from Task join ( TaskDetail join Status on TaskDetail.statusId = Status.statusId )
					 on Task.taskId = TaskDetail.taskId where Status.status != 'Delete' group by Task.tasklistId) Lower 
				on Upper.tasklistId = Lower.tasklistId
		) Progress
	on TaskList.tasklistId = Progress.tasklistId where Project.orgId = ? group by Module.moduleId )
	 Mdule group by Mdule.projectId", array(Session::get('orgId')));		
		
		$para['client'] = Client::where('Client.orgId',Session::get('orgId'))
					->Select('Client.clientId', 'Client.client')->get();

		$para['member'] = DB::select('Select Member.memberId, Member.member from Member left join 
			( users left join ( users_groups join groups on users_groups.group_id = groups.id ) 
			on users.id = users_groups.user_id) on Member.memberId = users.memberId 
			where Member.orgId = ? and groups.name <> "Member" order by users_groups.group_id',array(Session::get('orgId')));
		
		$para['org'] = Organization::where('orgId', Session::get('orgId'))->pluck('org');	

		return View::make('partials/project_list')->with(array('para'=>$para));						
	}

	public function project_authority_change() {		
		Project::where('Project.projectId', Input::get('projectId'))					
					->update(array('Project.authorizedBy'=>Input::get('memberId')));

		return Redirect::route('project_list');	
	}

	public function project_deactivate() {		
		Project::where('Project.projectId', Input::get('projectId'))					
					->update(array('Project.status'=>'Pending'));

		Module::where('Module.projectId', Input::get('projectId'))									
					->update(array('Module.status'=>'Pending'));
		
		$moduleIds = Module::where('Module.projectId', Input::get('projectId'))
					->select('moduleId')->get();
					
		foreach($moduleIds as $moduleId){
			TaskList::where('TaskList.moduleId', $moduleId->moduleId)						
					->update(array('TaskList.status'=>'Pending'));						
		}

		return Redirect::route('project_list');	
	}

	public function project_delete() {		
		$projectId = Input::get('projectId');
		Project::where('Project.projectId', $projectId)					
				->update(array('Project.status'=>'Cancel'));

		Module::where('Module.projectId', $projectId)					
					->update(array('Module.status'=>'Cancel'));
		
		$moduleIds = Module::where('Module.projectId', $projectId)
					->select('moduleId')->get();

		$i=0;
		foreach($moduleIds as $moduleId){
			TaskList::where('TaskList.moduleId', $moduleId->moduleId)						
					->update(array('TaskList.status'=>'Cancel'));
			$tasklistIds[$i] = TaskList::where('TaskList.moduleId', $moduleId->moduleId)
          		->select('tasklistId')->get();
      		$i++;						
		}

		$statusId = Status::where('Status.status','Cancel')->pluck('statusId');
		for($j=0;$j<$i;$j++){
	        foreach($tasklistIds[$j] as $tasklistId){
		        TaskDetail::where('Task.tasklistId', $tasklistId->tasklistId)         		        	
		        	->join('Task','TaskDetail.taskId','=','Task.taskId')
		            ->update(array('TaskDetail.statusId'=>$status));  
	        }
	    }

		$now = date('Y-m-d H:i:s');
		$notiId = Notification::insertGetId(array(
			'orgId'				=> Session::get('orgId'),
			'source'			=> 'prj' . Input::get('projectId'),
			'messageId'			=> 3,
			'dateToNoti'		=> $now,
			'createdDate'		=> $now,
			'createdBy'			=> Session::get('memberId')
		));

		NotiDetail::insert(array(
			'notiId'			=> $notiId,
			'notiTo'			=> Session::get('memberId')
		));

		return Redirect::route('project_list');	
	}

	public function project_detail() {	
		if(Input::get('projectId')!=null)
			$projectId = Input::get('projectId');	
		else
			$projectId = Input::old('projectId');

		$resolver = new Resolver;

		$page = Input::get('page');			
		if($page!=null)$page--;
		else $page=0;

		$limit = Input::get('limit');	
		if($limit==null)$limit=10;			

		Session::put('projectId',$projectId);

		$para['project'] = DB::select(
"select Mdule.projectId, Mdule.project, Mdule.desc, Mdule.startDate,Mdule.dueDate
    , Mdule.status, Mdule.member, Mdule.client, concat(sum(progress)/count(1), '%') progress from(
	select Project.projectId, Project.project, Project.desc, Project.startDate,Project.dueDate
			, Project.status, Member.member, Client.client, concat(sum(Progress.progress)/count(Module.moduleId), '%') progress  from Project
	left join 
			( Module left join TaskList on Module.moduleId = TaskList.moduleId ) 	
		on Project.projectId = Module.projectId
	left join Client on Project.clientId = Client.clientId
	left join Member on Project.authorizedBy = Member.memberId
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
	on TaskList.tasklistId = Progress.tasklistId where Project.projectId = ? group by Module.moduleId )
	 Mdule group by Mdule.projectId", array($projectId))[0];						

		$para['module'] = DB::select(
	"select Module.moduleId, Module.module, Module.desc, Module.startDate, Module.dueDate
		, Module.status, Project.authorizedBy, concat(sum(Progress.progress)/count(Module.moduleId), '%') progress, Module.active from Module
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
				( select Task.tasklistId, count(1) total from Task join 
						( TaskDetail join Status on TaskDetail.statusId = Status.statusId )
					 on Task.taskId = TaskDetail.taskId where Status.status != 'Delete' group by Task.tasklistId ) Lower 
			on Upper.tasklistId = Lower.tasklistId
	) Progress
on TaskList.tasklistId = Progress.tasklistId where Project.projectId = ? and Module.status <> 'Delete' group by Module.moduleId", array($projectId));

		$events = DB::select(
	"select Noti.notiId, Noti.createdDate Date, Member.member `By`
	, (case when substring(Noti.source,1,3)='prj' then 'Project' 
	   when substring(Noti.source,1,3)='mod' then 'Module'
	   when substring(Noti.source,1,3)='tkl' then 'TaskList'
	   when substring(Noti.source,1,3)='tsk' then 'Task'
		end) Type, Noti.source, Noti.messageId
	, NotiMessage.message Details, Noti.field from Notification Noti 
	join 
		( NotiMessage join NotiType on NotiMessage.NotiTypeId = NotiType.notiTypeId ) 
		on Noti.messageId = NotiMessage.messageId 
	join Member on Noti.createdBy = Member.memberId 
	where Noti.orgId = ? and NotiMessage.notiTypeId <> 2 order by Date desc, Noti.notiId desc", array(Session::get('orgId')));	

		$i = 0;
		foreach($events as $event){
			$sourceId = substr($event->source,3);		
			$event->Date = date_create($event->Date)->format('d-F-Y');
			if($event->Type=='Project'&&$sourceId==$projectId){
				if($event->messageId==2)					
					$event->Details = $resolver->detailResolver($event, $sourceId, 'projectUpdate');					
				
				else
					$event->Details = $resolver->detailResolver($event, $sourceId, 'project');					
				
			}
			else if($event->Type=='Module'&&Module::where('moduleId',$sourceId)->pluck('projectId')==$projectId){
				if($event->messageId==2)
					$event->Details = $resolver->detailResolver($event, $sourceId, 'moduleUpdate');					
				
				else
					$event->Details = $resolver->detailResolver($event, $sourceId, 'module');			
												
			}
			else if($event->Type=='TaskList'&&
				TaskList::where('tasklistId',$sourceId)->join('Module','TaskList.moduleId','=','Module.moduleId')
				->pluck('projectId')==$projectId){
				if($event->messageId==2)
					$event->Details = $resolver->detailResolver($event, $sourceId, 'tasklistUpdate');				
				
				else
					$event->Details = $resolver->detailResolver($event, $sourceId, 'tasklist');				
				
								
			}
			else if($event->Type=='Task'&&
				DB::select("select Module.projectId from Task join 
					( TaskList join Module on TaskList.moduleId = Module.moduleId ) 
					on Task.tasklistId = TaskList.tasklistId where Task.taskId = ?", array($sourceId))[0]->projectId==$projectId){
				if($event->messageId==4)
					$event->Details = $resolver->detailResolver($event, $sourceId, 'taskAssign');					
				
				else
					$event->Details = $resolver->detailResolver($event, $sourceId, 'task');				
			}
			else{
				unset($events[$i]);				
			}
			$i++;
		};
		$events = array_values($events);
		$j=0;
		$links = Paginator::make($events, count($events), $limit);

		for($i=0;$i<count($events);$i++){
			$paginator[$j][$i] = $events[$i];
			if($i!=0 && ($i+1)%$limit==0)$j++;			
		}

		if(Input::get('limit')!=null)
			return View::make('partials/event')->with(array('para'=> $para, 'events'=>$paginator[$page], 'links'=> $links, 'limit'=> $limit));	
		
		else
			return View::make('partials/project_detail')->with(array('para'=> $para, 'events'=>$paginator[$page], 'links'=> $links, 'limit'=> $limit));			
	}

	public function project_update() {		
		$projectId = Input::get('projectId');		
		$key	  = Input::get('key');
		$value    = Input::get('value');

		if($key=='project'||$key=='clientId'||$key=='authorizedBy'){
			$url = '/project_list';
		}
		else{
			$url = '/project_detail/?projectId=' . $projectId;	
		}

		if($key=='startDate'||$key=='dueDate'){
			$Date 		= date_create($value);
			$value		= $Date->format('Y-m-d H:i:s');	
		}				

		Project::where('projectId',$projectId)->update(array($key=>$value));

		$now = date('Y-m-d H:i:s');

		$notiId = Notification::insertGetId(array(
			'orgId'				=> Session::get('orgId'),
			'source'			=> 'prj' . $projectId,
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
}

 ?>

					