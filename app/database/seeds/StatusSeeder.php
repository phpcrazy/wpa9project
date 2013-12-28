<?php

class StatusSeeder extends Seeder {
 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

		DB::table('Status')->insert(array('status'=>'Unchecked'));
        DB::table('Status')->insert(array('status'=>'Checked'));
        DB::table('Status')->insert(array('status'=>'Just Start'));
        DB::table('Status')->insert(array('status'=>'Pending'));
        DB::table('Status')->insert(array('status'=>'Progress'));
        DB::table('Status')->insert(array('status'=>'Cancel'));
        DB::table('Status')->insert(array('status'=>'Delete'));           
        DB::table('Status')->insert(array('status'=>'Complete'));
        DB::table('Status')->insert(array('status'=>'Finish'));
	}
 
}
?>