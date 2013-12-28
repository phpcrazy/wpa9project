<?php

class NotiTypeSeeder extends Seeder {
 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

		DB::table('NotiType')->insert(array('notiType'=>'info'));
        DB::table('NotiType')->insert(array('notiType'=>'alert'));
        DB::table('NotiType')->insert(array('notiType'=>'status change'));        
	}
 
}
?>