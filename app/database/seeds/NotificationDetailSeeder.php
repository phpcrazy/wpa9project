<?php
class NotificationDetailSeeder extends Seeder {
 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){ 

        // $org_id = DB::table('Organization')                    
        //             ->where('org', 'Myanmar Links')
        //             ->pluck('orgId');  
                    
        // $mem_id = DB::table('Member')                                
        //             ->where('member', 'John')
        //             ->where('orgId', $org_id)
        //             ->pluck('memberId');   

		DB::table('NotificationDetail')->insert(array('notiId'=>1, 'memberId'=>1));
	}
 
}
?>