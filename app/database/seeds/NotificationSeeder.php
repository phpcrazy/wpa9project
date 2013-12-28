<?php
class NotificationSeeder extends Seeder {
 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
    	$now = date('Y-m-d H:i:s');

    	$org_id = DB::table('Organization')                    
                    ->where('org', 'Myanmar Links')
                    ->pluck('orgId');                   
        
        $notiType_id = DB::table('NotiType') 
                    ->where('notiType', 'alert')
                    ->pluck('notiTypeId'); 

        $member_id = DB::table('Member') 
                    ->where('member', 'John')
                    ->where('orgId', $org_id)
                    ->pluck('memberId'); 

		DB::table('Notification')->insert(array('orgId'=>$org_id, 'source'=>'Task', 'notiTypeId'=>$notiType_id, 'messageId'=>1, 'dateToNoti'=>$now, 'createdBy'=>$member_id));
	}
 
}
?>