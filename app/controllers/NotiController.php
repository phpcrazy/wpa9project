<?php 

class NotiController extends BaseController{
	public function notification(){
		$date = date('Y-m-d H:i:s');

		if(Input::get('date')==null&&Input::get('num')==null){											
			$day = 0;		
			$num = 0;
		}
		else{
			if(Input::get('num')!=null)
				$num = Input::get('num');

			else
				$num=0;
					
			if(getdate()['year']!=date('Y',strtotime(Input::get('date'))))	
				$temp = (getdate()['yday'] + 1) + date("z", mktime(0,0,0,12,31, getdate()['year'])) + 1;
			
			else
				$temp = getdate()['yday'] + 1;

			$day = $temp - (date("z",strtotime(Input::get('date')))+1);						
		}				
		
		$resolver = new Resolver;

		$clients = Client::where('orgId', Session::get('orgId'))
					->select('clientId','client')->get();		

		$notis = DB::select(
	"select Noti.notiId, Noti.dateToNoti Date, Member.member `By`
	, (case when substring(Noti.source,1,3)='prj' then 'Project' 
	   when substring(Noti.source,1,3)='mod' then 'Module'
	   when substring(Noti.source,1,3)='tkl' then 'TaskList'
	   when substring(Noti.source,1,3)='tsk' then 'Task'
		end) Type, Noti.source, Noti.messageId, NotiMessage.notiTypeId
	, NotiMessage.message Details, Noti.field from Notification Noti 
	join NotiDetail on Noti.notiId = NotiDetail.notiId
	join 
		( NotiMessage join NotiType on NotiMessage.NotiTypeId = NotiType.notiTypeId ) 
		on Noti.messageId = NotiMessage.messageId 
	join Member on Noti.createdBy = Member.memberId 
	where Noti.orgId = ? and NotiDetail.notiTo = ? and ( NotiMessage.notiTypeId = 1 or NotiMessage.notiTypeId = 3 or ( NotiMessage.notiTypeId = 2 and Noti.dateToNoti <= CURDATE() ) ) order by Date desc, Noti.notiId desc", array(Session::get('orgId'),Session::get('memberId')));	
		
		if(count($notis)==null)
			return View::make('partials/home')->with(array('clients'=>$clients));

		$notis0 = $notis;

		$j = 0;
		for($j=0;$j<30;$j++){
			$i = 0;
			foreach($notis as $noti){
				$sourceId = substr($noti->source,3);		
				if($noti->notiTypeId != 2){
					if(date("d",strtotime($noti->Date)) == date("d",strtotime($date))){
						if($j==$day)
							$noti->Details = $resolver->typeResolver($noti, $sourceId);
					}
						
					else
						unset($notis[$i]);		

				}
				else{
					if(2 + (date("z",strtotime($noti->Date)) - date("z",strtotime($date)))>=0&&
					   2 + (date("z",strtotime($noti->Date)) - date("z",strtotime($date)))<3){
						if($j==$day)
							$noti->Details = $resolver->alertResolver($noti, $sourceId, $date);
					}					 
						
					else
						unset($notis[$i]);		

				}
				$i++;		

			}
			$date = date_sub(date_create($date), date_interval_create_from_date_string('1 day'));
			$date = $date->format('Y-m-d H:i:s');
			$count[$j] = count($notis);	
			if($j==$day)$notis1 = $notis;				
			$notis = $notis0;
		}	

		if($notis1!=null){			
			$notis1 = array_values($resolver->notiSortType($notis1));			
			$sourceId = substr($notis1[$num]->source,3);			
			$desc = $resolver->descResolver($notis1[$num]->Type, $sourceId);				
		}		
		else{
			if(Input::get('date')!=null)
				return View::make('partials/noti_detail')->with(array('clients'=>$clients, 'count'=> $count));	

			return View::make('partials/home')->with(array('clients'=>$clients, 'count'=> $count));
		}

		
		if(Input::get('num')!=null)
			return View::make('partials/description')->with(array('notis'=>$notis1, 'clients'=>$clients, 'count'=> $count, 'desc'=>$desc));		

		if(Input::get('date')!=null)
			return View::make('partials/noti_detail')->with(array('notis'=>$notis1, 'clients'=>$clients, 'count'=> $count, 'desc'=>$desc));		

		return View::make('partials/home')->with(array('notis'=>$notis1, 'clients'=>$clients, 'count'=> $count, 'desc'=>$desc));
	}
}
?>