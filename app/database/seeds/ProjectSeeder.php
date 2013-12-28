<?php
class ProjectSeeder extends Seeder {
 
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
        
        $mem_id = DB::table('Member')                                
                                ->where('member', 'John')
                                ->where('orgId', $org_id)
                                ->pluck('memberId');    
        
        $client_id = DB::table('Client')                                
                                ->where('client', 'wpa9')
                                ->where('orgId', $org_id)
                                ->pluck('clientId');                                                             
		DB::table('Project')->insert(array('orgId'=>$org_id, 'project'=>'PM_Project', 'startDate'=>$now, 'dueDate'=>$now, 'authorizedBy'=>$mem_id, 'clientId'=>$client_id));
	}
 
}
?>