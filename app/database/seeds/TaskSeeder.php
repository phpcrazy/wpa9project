<?php
class TaskSeeder extends Seeder {
 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
    	$now = date('Y-m-d H:i:s');                  

        // $member_id = DB::table('Member') 
        //             ->where('member', 'John')
        //             ->where('orgId', $org_id)
        //             ->pluck('memberId'); 

        // $priority_id = DB::table('Priority') 
        //             ->where('priority', 'Low')
        //             ->pluck('priorityId'); 

		DB::table('Task')->insert(array('task'=>'Dummy'));
	}
 
}
?>