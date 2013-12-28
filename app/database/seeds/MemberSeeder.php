<?php
class MemberSeeder extends Seeder {
 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
    	$org_id = DB::table('Organization')                    
                    ->where('org', 'Myanmar Links')
                    ->pluck('orgId');        
                                                  
		DB::table('Member')->insert(array('orgid'=>$org_id, 'member'=>'John'
            , 'address'=>'Bahan', 'phone'=>'112233'));
	}
 
}
?>