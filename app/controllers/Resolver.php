<?php

class Resolver{
	public function fieldResolver($temp){
		if($temp == 'project'||$temp == 'module'||$temp == 'tasklist'||$temp == 'task')return 'title field';
		else if($temp == 'desc')return 'description field';
		else return $temp . ' field';
	}

	public function detailResolver($event, $source, $tmp){
		$detail = substr_replace($event->Details, $event->By, 0, 1);					
		
		if($tmp=="project"||$tmp=="projectUpdate")
			$temp = Project::where('projectId', $source)->pluck('project');													
			
		else if($tmp=="module"||$tmp=="moduleUpdate")
			$temp = Module::where('moduleId', $source)->pluck('module');			
		
		else if($tmp=="tasklist"||$tmp=="tasklistUpdate")
			$temp = TaskList::where('tasklistId', $source)->pluck('tasklist');
		
		else if($tmp=="task")
			$temp = Task::where('taskId', $source)->pluck('task');

		else if($tmp=="taskAssign"){
			$temp = Task::where('taskId', $source)->pluck('task');
			$detail = substr_replace($detail, $temp , stripos($detail,':')+2, 1);
			$temp = Member::where('memberId',$event->field)->pluck('member');
			return substr_replace($detail, $temp , strlen($detail)-1);
		}		

		if($tmp=="projectUpdate"||$tmp=="moduleUpdate"||$tmp=="tasklistUpdate"){
			$field = $this->fieldResolver($event->field);
			$detail = substr_replace($detail, $field , stripos($detail,'?',1), 1);	
		}

		return substr_replace($detail, $event->Type . ' : ' . $temp , strlen($detail)-1);
	}

	public function typeResolver($tmp, $sourceId){
		if($tmp->Type=='Project'){
			if($tmp->messageId==2)	
				return $this->detailResolver($tmp, $sourceId, 'projectUpdate');

			else
				return $this->detailResolver($tmp, $sourceId, 'project');					
			
		}
		else if($tmp->Type=='Module'){
			if($tmp->messageId==2)
				return $this->detailResolver($tmp, $sourceId, 'moduleUpdate');					
			
			else
				return $this->detailResolver($tmp, $sourceId, 'module');			
											
		}
		else if($tmp->Type=='TaskList'){
			if($tmp->messageId==2)
				return $this->detailResolver($tmp, $sourceId, 'tasklistUpdate');				
			
			else
				return $this->detailResolver($tmp, $sourceId, 'tasklist');				
			
							
		}
		else if($tmp->Type=='Task'){
			if($tmp->messageId==4)
				return $this->detailResolver($tmp, $sourceId, 'taskAssign');					
			
			else
				return $this->detailResolver($tmp, $sourceId, 'task');				
		}		
	}

	public function alertResolver($tmp, $source, $date){
		if($tmp->Type=="Project")
			$temp = Project::where('projectId', $source)->pluck('project');													
			
		else if($tmp->Type=="Module")
			$temp = Module::where('moduleId', $source)->pluck('module');			
		
		else if($tmp->Type=="TaskList")
			$temp = TaskList::where('tasklistId', $source)->pluck('tasklist');
		
		else if($tmp->Type=="Task")
			$temp = Task::where('taskId', $source)->pluck('task');

		$detail = substr_replace($tmp->Details, $tmp->Type . ' : ' . $temp, 0, 1);

		$daysToNoti = 2 + date("d",strtotime($tmp->Date)) - date("d",strtotime($date));

		if($daysToNoti==0)return substr_replace($detail, "due date" , stripos($detail,'?'));  

		return substr_replace($detail, $daysToNoti , stripos($detail,'?'), 1);
	}

	public function notiSortType($tmps){
		$i = 0;
		foreach($tmps as $tmp){
			if($tmp->notiTypeId==2)
				$temp[$i] = $tmp;
			$i++;
		}
		foreach($tmps as $tmp){
			if($tmp->notiTypeId==3)
				$temp[$i] = $tmp;
			$i++;
		}
		foreach($tmps as $tmp){
			if($tmp->notiTypeId==1)
				$temp[$i] = $tmp;
			$i++;
		}
		return $temp;
	}

	public function descResolver($tmp, $source){		
		if($tmp=="Project")
			return Project::where('projectId', $source)->select('project as title','desc')->get();													
			
		else if($tmp=="Module")
			return Module::where('moduleId', $source)->select('module as title','desc')->get();			
		
		else if($tmp=="TaskList")
			return TaskList::where('tasklistId', $source)->select('tasklist as title','desc')->get();
			
		else if($tmp=="Task")
			return Task::where('Task.taskId', $source)->join('TaskDetail','Task.taskId','=','TaskDetail.taskId')->select('task as title','desc')->get();
		
	}
}

?>